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
            "DOB"
        ];
    }

    /**
     * Validate item data.
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->errors = [];
        if (empty($data["username"])) {
            $this->errors["username"] = "Name is required.";
        }
        if (empty($data["NIC"])) {
            $this->errors["NIC"] = "NIC is required.";
        }
        return empty($this->errors);
    }

    // public function itemsSearch(array $data): array
    // {
    //     $like_columns = ["items.item_name", "items.brand", "items.description", "units.unit_name", "categories.category_name"];

    //     return $this->select(["item_id", "item_name", "description", "units.unit_name AS units_name", "categories.category_name AS category_name"])
    //         ->join("units", "unit", "unit_id")
    //         ->join("categories", "category", "category_id")
    //         ->contains($like_columns, $data["search"] ?? "")
    //         ->and("categories.category_name", $data["category"] ?? "")
    //         ->fetchAll();
    // }

    public function getEmployees(): array
    {
        return $this->select(["emp_id", "first_name", "last_name", "role", "salary", "DOB", "contact_no", "NIC"])
            ->fetchAll();
    }
}