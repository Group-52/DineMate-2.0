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

    public function addGuest($data): void
    {
        $this->insert($data);
    }
}