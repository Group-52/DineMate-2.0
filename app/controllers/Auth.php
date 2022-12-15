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
            redirect("auth/login");
        } else {
            redirect("home");
        }
    }

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
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
        }
        $this->view("login", $data);
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("auth/login");
    }

    public function signup(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            if ($user->validate($_POST)) {
                $_POST['password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $user->addUser($_POST);
                    redirect("auth/login");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->getErrors();
            }
        }
        $this->view("signup", $data);
    }
}
