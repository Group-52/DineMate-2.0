<?php

namespace models;

use core\Model;

/**
 * User Model
 */
class AdminUser extends Model
{

    public function __construct()
    {
        $this->table = "employees";
        $this->columns = [
            "emp_id",
            "first_name",
            "last_name",
            "username",
            "salary",
            "contact_no",
            "NIC",
            "date_employed",
            "role",
            "email",
            "password",
            "last_login"
        ];
    }

    /**
     * Get user by username
     * @param string $username
     * @return object|false
     */
    public function getUserByUsername(string $username): object|false
    {
        return $this->select()->where("username", $username)->fetch();
    }
}