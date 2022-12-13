<?php
/**
 * User Model
 */

class AdminUser extends Model
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

    /**
     * Validate user data.
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->errors = [];
        if (empty($data["first_name"])) {
            $this->errors["first_name"] = "First name is required.";
        }
        if (empty($data["last_name"])) {
            $this->errors["last_name"] = "Last name is required.";
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
        if (empty($data["password_confirm"])) {
            $this->errors["password_confirm"] = "Password confirmation is required.";
        }
        if ($data["password"] !== $data["password_confirm"]) {
            $this->errors["password_confirm"] = "Passwords do not match.";
        }
        return empty($this->errors);
    }
}