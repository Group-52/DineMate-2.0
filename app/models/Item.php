<?php

namespace models;

use core\Model;

/**
 * Items Model
 */
class Item extends Model
{
    public function __construct()
    {
        $this->table = "items";
        $this->columns = [
            "item_id",
            "item_name",
            "description",
            "unit",
            "category",
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
        if (empty($data["name"])) {
            $this->errors["name"] = "Name is required.";
        }
        if (empty($data["unit"])) {
            $this->errors["unit"] = "Measure is required.";
        }
        return empty($this->errors);
    }

    public function itemsSearch(array $data): array
    {
        $like_columns = ["items.item_name", "items.brand", "items.description", "units.unit_name", "categories.category_name"];

        return $this->select(["item_id", "item_name", "description", "units.unit_name AS units_name", "categories.category_name AS category_name"])
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->contains($like_columns, $data["search"] ?? "")
            ->and("categories.category_name", $data["category"] ?? "")
            ->fetchAll();
    }

    public function getItems(): array
    {
        return $this->select(["item_id", "item_name", "description","units.abbreviation, categories.category_name"])
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->orderBy("item_name")
            ->fetchAll();
    }
}