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

    public function getEmployees(): bool|array
    {
        return $this->select(["employees.*","roles.*"])
            ->join("roles","employees.role","roles.role_id")
            ->fetchAll();
    }

    public function getEmployee($emp_id): object|false
    {
        return $this->select(["employees.*","roles.*"])
            ->join("roles","employees.role","roles.role_id")
            ->where("emp_id", $emp_id)->fetch();
    }

    public function addEmployee($data): void
    {
        $this->insert($data);
    }

    public function editEmployee($data)
    {
        $this->update($data)->where("emp_id", $data['emp_id'])->execute();
    }

    public function deleteEmployee($data)
    {
        $this->delete()->where("emp_id", $data)->execute();
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