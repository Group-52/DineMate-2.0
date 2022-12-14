<?php
class loginK{
    use Controller;
    public function index()
    {
        echo "HI";
    }
    public function signup(){	
		if(isset($_POST['register'])){
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$contactNo = $_POST['contactNo'];
			$email = $_POST['email'];
			$password = $_POST['password'];

	 		$manageruser = new ManagerUser;
	 		$manageruser ->signup([
	 			'fname'=> $fname,
	 			'lname'=> $lname,
	 			'contactNo'=> $contactNo,
	 			'email'=> $email,
				'password'=> $password
	 		]);

			 //header('Location: login');
			
	 	}
         $this->view("signupK");
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