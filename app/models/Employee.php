<?php

namespace models;

use core\Model;

/**
 * Employees Model
 */
class Employee extends Model
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
            "last_login",
            // "DOB"
        ];
    }

    public function validate(array $data): bool
    {
        $this->errors = [];

        if (empty($data['name']))
            $this->errors['name'] = 'Name is required';

        if (empty($this->errors))
            return true;

        return false;
    }

    public function getEmployee(): bool|array
    {
        return $this->select()->fetchAll();
    }

    public function addEmployee($data): void
    {
        $this->insert($data);
    }
}