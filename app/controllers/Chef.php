<?php

/**
 * Login Controller
 */

class Chef
{
    use Controller;

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("chef/login");
        } else {
            redirect("home");
        }
    }

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ChefUser();
            try {
                $result = $user->select()->where("email", $_POST["email"])->fetch();

                if (!isset($result[0]))
                    $data["errors"] = "Invalid email or password.";
                else {
                    if (password_verify($_POST["password"], $result->password)) {
                        $_SESSION["user"] = $result;
                        redirect("orders");
                    } else {
                        $data["errors"] = "Invalid email or password.";
                    }
                }
            } catch (Exception $e) {
                $data["errors"] = "Unknown error.";
            }
        }
        $this->view("chef.login", $data);
    }


    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("chef/login");
    }


    public function signup(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ChefUser();
            if ($user->validate($_POST)) {
                $_POST['password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $_POST["role"] = "1";
                    $user->insert($_POST);
                    redirect("chef/login");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->getErrors();
            }
        }
        $this->view("chef.signup", $data);
    }
}
