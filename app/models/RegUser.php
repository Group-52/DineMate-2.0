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
            "verified_email"
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
        return $this->select()->fetchAll();
    }


    // public function getReguser($firstname): object|false
    // {
    //     return $this->select()->where("first_name", $firstname)->fetch();
    // }
}