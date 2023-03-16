<?php

namespace controllers;

use components\Form;
use core\Controller;
use Exception;
use models\RegUser;

/**
 * Login Controller
 */
class Auth
{
    use Controller;

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("auth/login");
        } else {
            redirect("home");
        }
    }

    public function login(): void
    {
        $data = [];

        $loginForm = new Form("", "POST", "Login");
        $loginForm->addInputField("email", "email", "email", "Email", true);
        $loginForm->addInputField("password", "password", "password", "Password", true);
        $data["form"] = $loginForm;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            if ($loginForm->isValid($_POST)) {
                try {
                    $result = $user->getUserByEmail($_POST["email"]);
                    if (!$result)
                        $data["errors"] = "Invalid email or password.";
                    else {
                        if (password_verify($_POST["password"], $result->password)) {
                            $_SESSION["user"] = $result;
                            redirect("home");
                        } else {
                            $data["errors"] = "Invalid email or password.";
                        }
                    }
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $loginForm->getErrors();
            }
        }
        $data["title"] = "Login";
        $this->view("login", $data);
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("auth/login");
    }

    public function register(): void
    {
        $data = [];

        $registerForm = new Form("", "POST", "Register");
        $registerForm->addInputField("first_name", "first_name", "text", "First Name", true);
        $registerForm->addInputField("last_name", "last_name", "text", "Last Name", true);
        $registerForm->addInputField("email", "email", "email", "Email", true);
        $registerForm->addInputField("contact_no", "contact_no", "text", "Contact No", true);
        $registerForm->addInputField("password", "password", "password", "Password", true);
        $registerForm->addInputField("confirm_password", "confirm_password", "password", "Confirm Password", true);
        $data["form"] = $registerForm;
        $data["page_titles"] = ["Your Details", "How can we contact you?", "Create a password"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            if ($registerForm->isValid($_POST)) {
                if ($_POST["password"] === $_POST["confirm_password"]) {
                    $_POST['password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    try {
                        $user->addUser($_POST);
                        $result = $user->getUserByEmail($_POST["email"]);
                        $_SESSION["user"] = $result;
                        redirect("profile/verify");
                    } catch (Exception $e) {
                        $data["errors"] = $user->getErrors();
                    }
                } else {
                    $data["errors"] = "Passwords do not match.";
                }
            } else {
                $data["errors"] = $registerForm->getErrors();
            }
        }
        $data["title"] = "Register";
        $this->view("register", $data);
    }
}
