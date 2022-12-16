<?php
class loginK{
    use Controller;
    public function index()
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
                $data["errors"] = $user->errors;
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
                $result = $user->findBy(["email" => $_POST["username"]]);
                if (password_verify($_POST["password"], $result[0]->password)) {
                    $_SESSION["user"] = $result[0];
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