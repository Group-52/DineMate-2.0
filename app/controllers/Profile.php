<?php

namespace controllers;

use components\Form;
use core\Controller;
use models\OTPRegUser;
use utils\Mailer;

class Profile
{
    use Controller;

    public function index(): void
    {
        if (isset($_SESSION["user"])) {
            redirect("profile/info");
        } else {
            redirect("login");
        }
    }

    public function info(): void
    {
        if (isset($_SESSION["user"])) {
            $data = [];
            $form = new Form("", "POST", "Update Profile");
            $form->addField("first_name", "first_name", "text", "First Name", true, value: $_SESSION["user"]->first_name);
            $form->addField("last_name", "last_name", "text", "Last Name", true, value: $_SESSION["user"]->last_name);
            $form->addField("email", "email", "email", "Email", true, value: $_SESSION["user"]->email);
            $form->addField("tel", "tel", "tel", "Contact Number", true, value: $_SESSION["user"]->contact_no);
            $data["form"] = $form;
            $this->view("profile", $data);
        } else {
            redirect("login");
        }
    }

    public function verify(): void
    {
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            if ($user->verified_email == 1) {
                redirect("profile/info");
            } else {
                $data = [];
                $data["title"] = "Verify Email";
                $data["email"] = $user->email;

                $otp = (new OTPRegUser)->getOTP($user->user_id);

                if ($otp != null) {
                    $mailer = new Mailer();
                    $html = "<h1>Welcome to DineMate</h1>";
                    $html .= "<p>Thank you for registering with us. Please verify your email address by entering the following code on the email verification page:</p>";
                    $html .= "<h2>" . $otp . "</h2>";
                    $data["success"] = $mailer->send($user->email, "Verify your email address - " . APP_NAME, $html);
                }
                $this->view("verify-email", $data);
            }
        } else {
            redirect("auth");
        }
    }
}