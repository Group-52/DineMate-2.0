<?php

class LoginK
{
    use Controller;

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("loginK/login");
        } else {
            redirect("vendor");
        }
    }

    public function signup(): void
    {

        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $user = new ManagerUser();
            if ($user->validate($_POST)) {
                print_r($_SERVER["REQUEST_METHOD"]);
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $_POST["role"] = "2";
                    $user->insert($_POST);
                    redirect("loginK/login");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->getErrors();
            }
        }
        $this->view("signupK", $data);
    }

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ManagerUser();
            try {
                $result = $user->select()->where("email", $_POST["username"])->fetch();
                if (password_verify($_POST["password"], $result->password)) {
                    $_SESSION["user"] = $result;
                    redirect("home");
                } else {
                    $data["error"] = "Invalid email or password.";
                }
            } catch (Exception $e) {
                $data["error"] = "Unknown error.";
            }
        }
        $this->view("loginK", $data);
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("loginK/login");
    }
}