<?php

namespace models;

use core\Model;

// Vendor class

class Vendor extends Model
{

    public function __construct()
    {
        $this->table = "vendors";
        $this->columns = [
            "vendor_id",
            "vendor_name",
            "address",
            "company",
            "contact_no",
            "email"
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

    public function getVendors(): bool|array
    {
        return $this->select()->fetchAll();
    }

    public function getVendor($vendor_id): object|false
    {
        return $this->select()->where("vendor_id", $vendor_id)->fetch();
    }

    public function addVendor($data): void
    {
        $this->insert($data);
    }

    public function editVendor($vendor)
    {
        $this->update($vendor)->where("vendor_id", $vendor['vendor_id'])->execute();
    }
}

