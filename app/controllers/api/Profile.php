<?php

namespace controllers\api;

use core\Controller;
use models\OTPRegUser;
use models\RegUser;
use utils\Mailer;

class Profile
{
    use Controller;

    public function resendOTP(): void
    {
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            if ($user->verified_email == 1) {
                $this->json([
                    "status" => "success",
                    "message" => "Email already verified"
                ]);
            } else {
                $otp = (new OTPRegUser)->generateNewOTP($user->user_id);
                $mailer = new Mailer();
                $html = "<h1>Welcome to DineMate</h1>";
                $html .= "<p>Thank you for registering with us. Please verify your email address by entering the following code on the email verification page:</p>";
                $html .= "<h2>" . $otp . "</h2>";
                if ($mailer->send($user->email, "Verify your email address - " . APP_NAME, $html)) {
                    $this->json([
                        "status" => "success",
                        "message" => "Email sent"
                    ]);
                } else {
                    $this->json([
                        "status" => "error",
                        "message" => "Email not sent"
                    ]);
                }
            }
        } else {
            $this->json([
                "status" => "error",
                "message" => "User not logged in"
            ]);
        }
    }

    public function verify(): void
    {
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            if ($user->verified_email == 1) {
                $this->json([
                    "status" => "success",
                    "message" => "Email already verified"
                ]);
            } else {
                $post = json_decode(file_get_contents('php://input'));
                $otp = $post->otp;
                $otpRegUser = (new OTPRegUser)->select()->where("user_id", $user->user_id)->and("otp", $otp)->and("time_of_expiry", date('Y-m-d H:i:s'), ">")->fetch();
                if ($otpRegUser) {
                    $regUser = new RegUser();
                    $regUser->update(["verified_email" => 1])->where("user_id", $user->user_id)->execute();
                    $_SESSION["user"] = $regUser->getUserByEmail($user->email);
                    (new OTPRegUser())->invalidateOTP($user->user_id);

                    $this->json([
                        "status" => "success",
                        "message" => "Email verified"
                    ]);
                } else {
                    $this->json([
                        "status" => "error",
                        "message" => "Invalid OTP"
                    ]);
                }
            }
        } else {
            $this->json([
                "status" => "error",
                "message" => "User not logged in"
            ]);
        }
    }
}