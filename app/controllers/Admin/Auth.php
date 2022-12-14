<?php

/**
 * Login Controller
 */

class Auth
{
    use Controller;

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth/login");
        } else {
            redirect("admin");
        }
    }

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new AdminUser();
            try {
                $result = $user->select()->where("username", $_POST["username"])->fetch();
                if (!isset($result)) {
                    $data["error"] = "Username or password is incorrect";
                } else {
                    if (password_verify($_POST["password"], $result->password)) {
                        $_SESSION["user"] = $result;
                        redirect("admin");
                    } else {
                        $data["error"] = "Invalid email or password.";
                    }
                }
            } catch (Exception $e) {
                $data["error"] = "Unknown error.";
            }
        }
        $this->view("admin.login", $data);
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("admin/auth/login");
    }

    public function register(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new AdminUser();
            if ($user->validate($_POST)) {
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $_POST["role"] = "4";
                    $user->insert($_POST);
                    redirect("admin/auth/login");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->getErrors();
            }
        }
        $this->view("admin.register", $data);
    }
}
