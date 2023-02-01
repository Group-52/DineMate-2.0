<?php

namespace models;

use core\Model;

/**
 * Vendors Model
 */
class Vendor extends Model
{
    public function __construct()
    {
        $this->table = "vendors";
        $this->columns = [
            "vendor_id",
            "vendor_name",
            "company",
            "contact_no",
            "email",
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
        if (empty($data["vendor_name"])) {
            $this->errors["vendor_name"] = "Name is required.";
        }
        if (empty($data["company"])) {
            $this->errors["company"] = "company is required.";
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

    public function getVendors(): array
    {
        return $this->select(["vendor_id", "vendor_name", "company"])
            ->fetchAll();
    }
}