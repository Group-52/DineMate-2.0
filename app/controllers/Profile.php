<?php

namespace controllers;

use components\Form;
use core\Controller;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use models\GeneralDetails;
use models\OTPRegUser;
use models\RegUser;
use utils\Mailer;

class Profile
{
    use Controller;

    #[NoReturn] public function index(): void
    {
        if (isRegistered()) {
            redirect("profile/info");
        } else {
            redirectToLogin();
        }
    }

    public function info(): void
    {
        if (isRegistered()) {
            $data = [];
            $form = new Form("", "POST", "Update Profile");
            $form->addInputField("first_name", "first_name", "text", "First Name", true, value: $_SESSION["user"]->first_name);
            $form->addInputField("last_name", "last_name", "text", "Last Name", true, value: $_SESSION["user"]->last_name);
            $form->addInputField("email", "email", "email", "Email", true, value: $_SESSION["user"]->email);
            $form->addInputField("tel", "tel", "tel", "Contact Number", true, value: $_SESSION["user"]->contact_no);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($form->isValid($_POST)) {
                    try {
                        $regUser = new RegUser();
                        $profile = [];

                        // If email is changed, set verified_email to 0
                        if ($_SESSION["user"]->email != $_POST["email"]) {
                           $profile["email"] = $_POST["email"];
                           $profile["verified_email"] = 0;
                           $_SESSION["user"]->verified_email = 0;
                           $_SESSION["user"]->email = $_POST["email"];
                        }

                        $profile["first_name"] = $_POST["first_name"];
                        $profile["last_name"] = $_POST["last_name"];
                        $profile["contact_no"] = $_POST["tel"];
                        $regUser->updateUserDetails($profile, userId());

                    } catch (Exception $e) {
                        $data["error"] = "Something went wrong. Please try again later.";
                    }
                }
            }

            $data["form"] = $form;
            $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
            $data["title"] = "Profile Info";
            $this->view("profile", $data);
        } else {
            redirectToLogin();
        }
    }

    public function settings(): void
    {
        if (isRegistered()) {
            $data = [];
            $form = new Form("", "POST", "Update Profile");
            $form->addInputField("old_password", "old_password", "password", "Old Password", true);
            $form->addInputField("new_password", "new_password", "password", "New Password", true);
            $form->addInputField("confirm_password", "confirm_password", "password", "Confirm Password", true);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($form->isValid($_POST)) {
                    $regUser = new RegUser();
                    try {
                        $regUser->updatePassword($_POST["new_password"], $_POST["confirm_password"], userId(), $_POST["old_password"]);
                        redirectToLogin();
                    } catch (Exception $e) {
                        $data["error"] = $e->getMessage();
                    }
                }
            }

            $data["form"] = $form;
            $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
            $data["title"] = "Profile Settings";
            $this->view("profile", $data);
        } else {
            redirectToLogin();
        }
    }

    public function verify(): void
    {
        if (isRegistered()) {
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
                    $html = "<h1>Welcome to <span style='color: #FF4546'>DineMate</span></h1>";
                    $html .= "<p>Thank you for registering with us. Please verify your email address by entering the following code on the email verification page:</p>";
                    $html .= "<h2>" . $otp . "</h2>";
                    $data["success"] = $mailer->send($user->email, "Verify your email address - " . APP_NAME, $html);
                }
                $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
                $this->view("verify-email", $data);
            }
        } else {
            redirectToLogin();
        }
    }
}