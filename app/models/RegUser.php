<?php

namespace models;

use core\Model;

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
            'blacklisted'
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

    public function addUser($data)
    {
        $this->insert([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "password" => $data["password"],
            "contact_no" => $data["contact_no"]
        ]);
    }

    public function getReg(): bool|array
    {
        return $this->select()->where("blacklisted", 0)->fetchAll();
    }

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

    public function updateLogin($id): void
    {
        $this->update(['last_login' => date("Y-m-d H:i:s")])->where('user_id', $id)->execute();
    }
}