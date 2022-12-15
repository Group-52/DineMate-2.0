<?php
class loginK{
    use Controller;
    public function index()
    {
        echo "HI";
    }

    // public function signup(): void
    // {
    //     $data = [];
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $user = new ManagerUser();
    //         if ($user->validate($_POST)) {
    //             $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
    //             try {
    //                 $_POST["role"] = "2";
    //                 $user->insert($_POST);
    //                 redirect("loginK/login");
    //             } catch (Exception $e) {
    //                 $data["errors"] = "Unknown error.";
    //             }
    //         } else {
    //             $data["errors"] = $user->errors;
    //         }
    //     }
    //     $this->view("signupK", $data);
    // }

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
			
		// if(isset($_POST['employees'])){
		// 	$first_name = $_POST['first_name'];
		// 	$last_name = $_POST['last_name'];
		// 	$contact_no = $_POST['contact_no'];
		// 	$email = $_POST['email'];
		// 	$password = $_POST['password'];

	 	// 	$manageruser = new ManagerUser;
	 	// 	$manageruser ->signup()[
	 	// 		'first_name'=> $first_name,
	 	// 		'last_name'=> $last_name,
	 	// 		'contact_no'=> $contact_no,
	 	// 		'email'=> $email,
		// 		'password'=> $password
	 	// 	]);

		// 	// header('Location: login');
			
	 	// }
        //  $this->view("signupK");
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
                    redirect("./logink/manager");
                } else {
                    $data["error"] = "Invalid email or password.";
                }
            } catch (Exception $e) {
                $data["error"] = "Unknown error.";
            }
        }
        $this->view("loginK", $data);
    }

    public function manager(): void
    {
        $this->view("manager");
    }
}