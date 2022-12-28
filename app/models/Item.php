<?php

/**
 * Item Model
 */

class Item extends Model
{
    public function __construct()
    {
        $this->table = "items";
        $this->columns = [
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
        $likeData = [];

        if (isset($data["query"])) {
            foreach ($like_columns as $column) {
                $likeData[$column] = $data["query"];
            }
            unset($data["query"]);
        }

        return $this->select(["item_id", "item_name", "description", "units.unit_name AS units_name", "categories.category_name AS category_name"])
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->containsAll($likeData)
            ->and("categories.category_name", $data["category"] ?? "")
            ->fetchAll();
    }
}