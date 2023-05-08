<?php

namespace controllers;

use components\Form;
use core\Controller;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use models\GeneralDetails;
use models\OTPRegUser;
use models\RegUser;
use models\Cart;
use utils\Mailer;

/**
 * Login Controller
 */
class Auth
{
    use Controller;

    #[NoReturn] public function index(): void
    {
        if (!isRegistered()) {
            redirect("auth/login");
        } else {
            redirect("home");
        }
    }

    public function login(): void
    {
        $data = [];
        $loginForm = new Form("", "POST", "Login");
        $loginForm->addInputField("email", "email", "email", "Email", true);
        $loginForm->addInputField("password", "password", "password", "Password", true);
        $data["form"] = $loginForm;
        $data["footer_details"] = (new GeneralDetails())->getFooterDetails();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            if ($loginForm->isValid($_POST)) {
                try {
                    $result = $user->getUserByEmail($_POST["email"]);
                    if (!$result)
                        $data["error"] = "Invalid email or password.";
                    else {
                        if (password_verify($_POST["password"], $result->password)) {
                            // Check if blacklisted
                            if ($result->blacklisted == 1) {
                                $data["error"] = "Your account has been blacklisted.";
                                $this->view("login", $data);
                                die;
                            }

                            $newUserId = $result->user_id;

                            //update last login
                            $user->updateLogin($newUserId);

                            // Transfer cart items to registered user account
                            if (isGuest()) {
                                $cart = new Cart;
                                if ($cart->getNoOfItems(userId(), true) > 0) {
                                   $cart->moveCartToRegistered(userId(), $newUserId);
                                }
                            }

                            // Log in user
                            $_SESSION["user"] = $result;
                            $_SESSION["user"]->registered = true;

                            // Redirect to previous page
                            if (isset($_GET["redirect"])) {
                                $redirect = $_SERVER["SERVER_NAME"] . $_GET["redirect"];
                                header("Location: http://" . $redirect);
                                die;
                            } else {
                                redirect("home");
                            }
                        } else {
                            $data["error"] = "Invalid email or password.";
                        }
                    }
                } catch (Exception $e) {
                    $data["error"] = "Unknown error.";
                }
            } else {
                $data["error"] = "Invalid email or password.";
                $data["errors"] = $loginForm->getErrors();
            }
        }
        $data["title"] = "Login";
        $this->view("login", $data);
    }

    #[NoReturn] public function logout(): void
    {
        session_destroy();
        redirect("auth/login");
    }

    public function register(): void
    {
        $data = [];

        $registerForm = new Form("", "POST", "Register");
        $registerForm->addInputField("first_name", "first_name", "text", "First Name", true);
        $registerForm->addInputField("last_name", "last_name", "text", "Last Name", true);
        $registerForm->addInputField("email", "email", "email", "Email", true);
        $registerForm->addInputField("contact_no", "contact_no", "text", "Contact No", true);
        $registerForm->addInputField("password", "password", "password", "Password", true);
        $registerForm->addInputField("confirm_password", "confirm_password", "password", "Confirm Password", true);
        $data["form"] = $registerForm;
        $data["page_titles"] = ["Your Details", "How can we contact you?", "Create a password"];
        $data["footer_details"] = (new GeneralDetails())->getFooterDetails();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new RegUser();
            if ($registerForm->isValid($_POST)) {
                if ($_POST["password"] === $_POST["confirm_password"]) {
                    $_POST['password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    try {
                        $user->addUser($_POST);
                        $result = $user->getUserByEmail($_POST["email"]);
                        $_SESSION["user"] = $result;
                        redirect("profile/verify");
                    } catch (Exception $e) {
                        $data["errors"] = $user->getErrors();
                    }
                } else {
                    $data["errors"] = "Passwords do not match.";
                }
            } else {
                $data["errors"] = $registerForm->getErrors();
            }
        }
        $data["title"] = "Register";
        $this->view("register", $data);
    }

    /**
     * Forgot Password and Email Verification
     * @return void
     */
    public function forgot(): void
    {
        $data = [];
        $forgotForm = new Form("", "POST", "Reset Password");
        $forgotForm->addInputField("email", "email", "email", "Email", true);
        $data["form"] = $forgotForm;
        $data["footer_details"] = (new GeneralDetails())->getFooterDetails();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($forgotForm->isValid($_POST)) {
                $email = $_POST["email"];

                $regUser = new RegUser();
                $user = $regUser->getUserByEmail($email);

                $otp = (new OTPRegUser)->getOTP($user->user_id);

                if ($otp != null) {
                    $mailer = new Mailer();
                    $html = "<h1>Reset Your Password to <span style='color: #FF4546'>DineMate</span></h1>";
                    $html .= "<p>You can reset your password by entering the following code on the email verification page:</p>";
                    $html .= "<h2>" . $otp . "</h2>";
                    $html .= "<p>If you did not request a password reset, kindly disregard this email.</p>";
                    $data["success"] = $mailer->send($user->email, "Reset your account password - " . APP_NAME, $html);
                } else {
                    $data["error"] = "Invalid email address.";
                }
                $data["email"] = $email;
                $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
                $this->view("verify-email.password", $data);
            }
        } else {
            $data["title"] = "Forgot Password";
            $this->view("forgot", $data);
        }
    }

    /**
     * Changing Password
     * @return void
     */
    public function change(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $code = "";
            if (isset($_POST["code-1"]) && isset($_POST["code-2"]) && isset($_POST["code-3"]) && isset($_POST["code-4"]) && isset($_POST["code-5"]) && isset($_POST["code-6"])) {
                $code = $_POST["code-1"] . $_POST["code-2"] . $_POST["code-3"] . $_POST["code-4"] . $_POST["code-5"] . $_POST["code-6"];
            }
            $newPassword = $_POST["password"];
            $newPasswordConfirm = $_POST["confirm-password"];

            $otp = new OTPRegUser;
            if ($otp->isValid($code) && $newPassword === $newPasswordConfirm) {
                $userId = $otp->getUserId($code);
                $regUser = new RegUser();

                try {
                    $regUser->updatePassword($newPassword, $newPasswordConfirm, $userId);
                    $otp->invalidateOTP($code);
                    redirect("auth/login");
                } catch (Exception $e) {
                    $data["error"] = $e->getMessage();
                }
            } else {
                $data["error"] = "Invalid code or passwords do not match.";
                $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
                $this->view("verify-email.password", $data);
            }
        }
    }
}
