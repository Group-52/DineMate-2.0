<?php

namespace controllers\admin;

use components\Form;
use core\Controller;
use Exception;
use models\AdminUser;

/**
 * Login Controller
 */
class Auth
{
    use Controller;

    private string $controller = "auth";

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth/login");
        } else {
            redirect("admin/home");
        }
    }

    public function login(): void
    {
        $data = [];
        $loginForm = new Form("", "POST", "Login");
        $loginForm->addInputField("username", "username", "text", "Username", true);
        $loginForm->addInputField("password", "password", "password", "Password", true);
        $data["form"] = $loginForm;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new AdminUser();
            if ($loginForm->isValid($_POST)) {

                try {
                    $result = $user->getUserByUsername($_POST["username"]);
                    if (!$result) {
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
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $loginForm->getErrors();
            }
        }
        $this->view("admin/login", $data);
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("admin/auth/login");
    }
}
