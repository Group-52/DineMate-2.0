<?php
class loginK{
    use Controller;
    public function index()
    {
        echo "HI";
    }
    public function signup(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ManagerUser();
            if ($user->validate($_POST)) {
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                try {
                    $_POST["role"] = "4";
                    $user->insert($_POST);
                    redirect("loginK");
                } catch (Exception $e) {
                    $data["errors"] = "Unknown error.";
                }
            } else {
                $data["errors"] = $user->errors;
            }
        }
        $this->view("loginK");
    }

    public function login(): void
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new ManagerUser();
            try {
                $result = $user->findBy(["username" => $_POST["username"]]);
                if (password_verify($_POST["password"], $result[0]->password)) {
                    $_SESSION["user"] = $result[0];
                    redirect("manager");
                } else {
                    $data["error"] = "Invalid email or password.";
                }
            } catch (Exception $e) {
                $data["error"] = "Unknown error.";
            }
        }
        $this->view("loginK", $data);
    }
}