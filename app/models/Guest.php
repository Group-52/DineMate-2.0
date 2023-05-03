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
    public function isValid(array $data): bool
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

    public function getGuestById($guest_id): false|object
    {
        return $this->select()->where('guest_id', $guest_id)->fetch();
    }

    /**
     * @param $fName
     * @param $lName
     * @param $contactNo
     * @param $email
     * @return false|int Returns false if query fails, else returns the last inserted id.
     */
    public function createGuest($fName = null, $lName = null, $contactNo = null, $email = null): false|int
    {
        $data = [
            'first_name' => $fName,
            'last_name' => $lName,
            'contact_no' => $contactNo,
            'email' => $email,
            'date_created' => date('Y-m-d H:i:s')
        ];
        $this->insert($data);
        return $this->lastInsertId();
    }

    public function deleteGuest($guest_id): void
    {
       $this->delete()->where('guest_id', $guest_id)->execute();
    }
}