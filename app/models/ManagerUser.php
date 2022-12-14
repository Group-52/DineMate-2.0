<?php
/**
 * User Model
 */

class ManagerUser extends Model
{

    public function __construct()
    {
        $this->table = "employees";
        $this->primary_key = "emp_id";
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
            "last_modified"
        ];
    }

    public function validate(array $data): bool
    {
        $this->errors = [];
        if (empty($data["fname"])) {
            $this->errors["fname"] = "First name is required.";
        }
        if (empty($data["lname"])) {
            $this->errors["lname"] = "Last name is required.";
        }

        if (empty($data["username"])) {
            $this->errors["username"] = "Username is required.";
        }

        if (empty($data["email"])) {
            $this->errors["email"] = "Email is required.";
        }

        if (empty($data["password"])) {
            $this->errors["password"] = "Password is required.";
        }
        if (empty($data["password_confirmation"])) {
            $this->errors["password_confirmation"] = "Password confirmation is required.";
        }
        if ($data["password"] !== $data["password_confirmation"]) {
            $this->errors["password_confirmation"] = "Passwords do not match.";
        }
        return empty($this->errors);
    }
}