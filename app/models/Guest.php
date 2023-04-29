<?php

namespace models;

use core\Model;

/**
 * Guest class
 */
class Guest extends Model
{
    public function __construct()
    {
        $this->table = "guest_users";
        $this->columns = [
            "guest_id",
            "first_name",
            "last_name",
            "contact_no",
            "email",
            "date_created"
        ];
    }

    /**
     * Validate data.
     * @param $data array
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->errors = [];

        if (empty($data['name']))
            $this->errors['name'] = 'Name is required';

        if (empty($this->errors))
            return true;

        return false;
    }

    /**
     * Get all guest users.
     */
    public function getGuest(): bool|array
    {
        return $this->select()->fetchAll();
    }

    //will return current time if successful
    public function addGuest($fname=null,$lname=null,$contactno=null,$email=null): bool|string
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'first_name' => $fname,
            'last_name' => $lname,
            'contact_no' => $contactno,
            'email' => $email,
            'date_created' => $now
        ];
        $this->insert($data);
        return $now;
    }
}