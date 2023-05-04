<?php

namespace utils;

class RouteAuth
{
    protected static array $common_controllers = ["auth", "_404", "_401", "_403"];

    protected static array $role_list = [1 => "Chef", 2 => "General Manager", 3 => "Cashier", 4 => "Inventory Manager", 5 => "Admin", 6 => "Customer"];

    protected static array $allowed_controllers = [
        "not_api" => [
            "Chef" => ["home","orders"],
            "Cashier" => ["home","payments"],
            "Inventory Manager" => ["home","dishes", "ingredients", "vendors", "inventory", "items", "purchases"],
            "Customer" => ["home","cart", "checkout", "dish", "menu", "profile", "orders"]
        ],
        "api" => [
            "Chef" => ["orders", "orderdishes"],
            "Cashier" => [],
            "Inventory Manager" => ["dishes", "ingredients", "vendors", "inventory", "items", "purchases", "stats"],
            "Customer" => ["home", "cart", "dishes", "profile", "purchases", "orders", "feedback", "guest"]
        ]
    ];

    public static function checkAuth($controller, string $module = ""): bool
    {
        if (!$controller) return false;
        $controller = strtolower($controller);

        if (in_array($controller, self::$common_controllers)) {
            return true;
        }

        //Check if user is logged in
        $user = $_SESSION['user'] ?? "Guest";
        $role = "Customer";
        //Check user role if it's an employee
        if ($user !== 'Guest' && isset($user->role))
            $role = self::$role_list[$user->role];
        if ($role == 'General Manager' || $role == 'Admin') {
            return true;
        }

        //Check if customer is trying to access admin dashboard
        if ($module === "admin" && $role == "Customer" && $controller !== "auth") {
            return false;
        }
        //check if the controller is in the allowed controllers
        $module = ($module === "api") ? "api" : "not_api";
        $allowed_controllers_arr = self::$allowed_controllers[$module][$role] ?? null;
        if ($allowed_controllers_arr && in_array($controller, $allowed_controllers_arr)) {
            return true;
        }
        return false;
    }

    public static function icon_visible($controller): bool
    {
        if (!$controller) return false;
        $controller = strtolower($controller);

        if (in_array($controller, self::$common_controllers)) {
            return true;
        }
        $role = "Customer";

        if (isset($_SESSION['user']->role)) {
            $role = self::$role_list[$_SESSION['user']->role];
            if ($role == 'General Manager' || $role == 'Admin') {
                return true;
            }
            $arr = self::$allowed_controllers["not_api"][$role];
            if (in_array($controller, $arr)) {
                return true;
            }
        }
        return false;
    }


    public static function guestSession($controller, $module): void
    {
        if (isNotLoggedIn() && empty($module)) {
            if (in_array($controller, self::$allowed_controllers["not_api"]["Customer"])) {

                $cookieName = "guest";

                $guest = new \models\Guest();

                if (isset($_COOKIE["guest"])) {
                    $guestId = $_COOKIE["guest"];
                } else {
                    $guestId = $guest->createGuest();
                    setcookie($cookieName, $guestId, time() + (86400 * 30 * 7), "/");
                }
                createSessionGuest($guestId);
            }
        }
    }
}

