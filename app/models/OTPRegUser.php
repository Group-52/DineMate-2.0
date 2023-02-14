<?php

namespace models;

use core\Model;

class OTPRegUser extends Model
{
    public function __construct()
    {
        $this->table = "otp_reg_users";
        $this->columns = [
            "user_id",
            "otp",
            "time_of_expiry",
        ];
    }

    public function generateNewOTP($user_id): string
    {
        $this->invalidateOTP($user_id);
        $otp = rand(100000, 999999);
        $this->insert([
            "user_id" => $user_id,
            "otp" => $otp,
        ]);
        return $otp;
    }

    public function getOTP($user_id): string|null
    {
        $row = $this->select()->where("user_id", $user_id)->and("time_of_expiry", date('Y-m-d H:i:s'), ">")->fetch();
        if ($row == null) {
            $otp = $this->generateNewOTP($user_id);
        } else {
            $otp = null;
        }
        return $otp;
    }

    public function invalidateOTP($user_id): void
    {
        $this->delete()->where("user_id", $user_id)->execute();
    }
}