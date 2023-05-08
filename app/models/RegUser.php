<?php

namespace models;

use core\Model;
use Exception;

/**
 * User class
 */
class RegUser extends Model
{

    public function __construct()
    {
        $this->table = "reg_users";
        $this->columns = [
            "user_id",
            "first_name",
            "last_name",
            "email",
            "password",
            "registered_date",
            "contact_no",
            "last_login",
            "verified_email",
            'blacklisted',
            "promo_id"
        ];
    }

    /**
     * Get user by email
     * @param string $email
     * @return object|false
     */
    public function getUserByEmail(string $email): object|bool
    {
        return $this->select()->where("email", $email)->fetch();
    }

    /**
     * Creates new registered user
     * @param $data array User data
     * @return void
     */
    public function addUser(array $data): void
    {
        $this->insert([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "password" => $data["password"],
            "contact_no" => $data["contact_no"]
        ]);
    }

    /**
     * @return bool|array
     */
    public function getReg(): bool|array
    {
        return $this->select()->where("blacklisted", 0)->fetchAll();
    }

    /**
     * @param $id
     * @return object|false
     */
    public function getUserById($id): object|false
    {
        return $this->select()->where("user_id", $id)->fetch();
    }

    public function blacklist($id,$blacklist=1): void
    {
        $this->update(['blacklisted' => $blacklist])->where('user_id', $id)->execute();
    }
    public function getBlacklist(): bool|array
    {
        return $this->select()->where("blacklisted", 1)->fetchAll();
    }


    public function getPromoId($userId): int
    {
        return $this->select(["promo_id"])->where("user_id",$userId)->fetch()->promo_id ?? 1;
    }

    public function setPromoId($userId, $promoId): void
    {
        $this->update(["promo_id" => $promoId])->where("user_id", $userId)->execute();
    }

    public function updateLogin($id): void
    {
        $this->update(['last_login' => date("Y-m-d H:i:s")])->where('user_id', $id)->execute();
    }

    /**
     * Updates Registered User details
     * @param $data array User data
     * @param $userId int User ID
     * @return void
     */
    public function updateUserDetails($data, $userId): void
    {
        $this->update($data)->where("user_id", $userId)->execute();
    }

    /**
     * Updates Registered User password
     * @param $currentPass string Current password
     * @param $newPass string New password
     * @param $confirmPass string Confirm password
     * @param $userId int User ID
     * @return void
     * @throws Exception
     */
    public function updatePassword(string $newPass, string $confirmPass, int $userId, string $currentPass = null): void
    {
        $user = $this->getUserById($userId);
        if (password_verify($currentPass, $user->password) || is_null($currentPass)) {
            if ($newPass == $confirmPass) {
                $this->update(["password" => password_hash($newPass, PASSWORD_DEFAULT)])->where("user_id", $userId)->execute();
            } else {
                throw new Exception("New password and confirm password do not match.");
            }
        } else {
            throw new Exception("Current password is incorrect.");
        }
    }

}