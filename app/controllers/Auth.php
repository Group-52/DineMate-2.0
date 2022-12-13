<?php

/**
 * Login Controller
 */

class Auth
{
    use Controller;

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            try {
                $result = $user->findBy(["email" => $_POST["email"]]);

                if (!isset($result[0]))
                    $data["errors"] = "Invalid email or password.";
                else {
                    if (password_verify($_POST["password"], $result[0]->password)) {
                        $_SESSION["user"] = $result[0];
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
                $_POST['password'] =  password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $user->insert($_POST);
                    redirect("auth/login");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->errors;
            }
        }
        $this->view("signup", $data);
    }
}
