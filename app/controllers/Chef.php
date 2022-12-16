<?php

/**
 * Login Controller
 */

class Chef
{
    use Controller;

    public function cheflogin(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ChefUser();
            try {
                $result = $user->findBy(["email" => $_POST["email"]]);

                if (!isset($result[0]))
                    $data["errors"] = "Invalid email or password.";
                else {
                    if (password_verify($_POST["password"], $result[0]->password)) {
                        $_SESSION["user"] = $result[0];
                        redirect("orders");
                    } else {
                        $data["errors"] = "Invalid email or password.";
                    }
                }
            } catch (Exception $e) {
                $data["errors"] = "Unknown error.";
            }
        }
        $this->view("chefLogin", $data);
    }


    public function logout(): void
    {
        unset($_SESSION["user"]);
        redirect("Chef/cheflogin");
    }



    public function chefsignup(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ChefUser();
            if ($user->validate($_POST)) {
                $_POST['password'] =  password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $_POST["role"] = "1";
                    $user->insert($_POST);
                    redirect("Chef/cheflogin");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->errors;
            }
        }
        $this->view("chefSignup", $data);
    }
}
