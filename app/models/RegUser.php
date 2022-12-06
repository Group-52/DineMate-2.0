<?php


/**
 * User class
 */
class RegUser
{
    use Model;

    public function __construct()
    {
        $this->table = "reg_users";
        $this->primary_key = "user_id";
        $this->columns = [
            "user_id",
            "fname",
            "lname",
            "email",
            "password",
            "registered_date",
            "contactNo",
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

        $exists = $this->findBy(['email' => $data['email']]);
        if ($exists)
            $this->errors['email'] = "Email already exists";

        if (empty($data["email"])) {
            $this->errors["email"] = "Email is required.";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        }

        if (empty($data['lname']))
            $this->errors['lname'] = "Last name is required";
        if (empty($data['fname']))
            $this->errors['fname'] = "First name is required";

        if (empty($data["password"])) {
            $this->errors["password"] = "Password is required.";
        }
        if (empty($data["password-confirm"])) {
            $this->errors["password-confirm"] = "Password confirmation is required.";
        }
        if ($data["password"] !== $data["password-confirm"]) {
            $this->errors["password-confirm"] = "Passwords do not match.";
        }
        return empty($this->errors);
    }
}

