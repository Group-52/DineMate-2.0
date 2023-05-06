<?php

namespace controllers\Admin;

use core\Controller;

class Profile
{
    use Controller;

    public function index(): void
    {
        $this->view('admin/profile');
    }
    public function personal(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['save'])) {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $contact_no = $_POST['contact_no'];
                $email = $_POST['email'];
                $id = $_SESSION['user']->emp_id;

                $empmodel = new \models\Employee();
                $empmodel->editEmployee([
                    "emp_id" => $id,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "contact_no" => $contact_no,
                    "email" => $email
                ]);

                $_SESSION['user']->first_name = $first_name;
                $_SESSION['user']->last_name = $last_name;
                $_SESSION['user']->contact_no = $contact_no;
                $_SESSION['user']->email = $email;

                $this->view('admin/profile', [
                    "pwd_success" => "Profile updated successfully"
                ]);
            }
        }

    }
    public function password():void{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['save'])){
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $id = $_SESSION['user']->emp_id;

                $empmodel = new \models\Employee();

                if(password_verify($old_password,$_SESSION['user']->password)){
                    if($new_password == $confirm_password){
                        $empmodel->editEmployee([
                            "emp_id" => $id,
                            "password" => password_hash($new_password,PASSWORD_DEFAULT)
                        ]);
                        $_SESSION['user']->password = password_hash($new_password,PASSWORD_DEFAULT);
                        $this->view('admin/profile',[
                            "pwd_success" => "Password changed successfully"
                        ]);
                    }else{
                        $this->view('admin/profile',[
                            "pwd_error" => "New password and confirm password does not match"
                        ]);
                    }
                }else{
                    $this->view('admin/profile',[
                        "pwd_error" => "Old password is incorrect"
                    ]);
                }
            }
        }
    }

}