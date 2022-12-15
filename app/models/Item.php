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
            "name",
            "brand",
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
        $like_columns = ["items.name", "items.brand", "items.description", "units.name", "categories.name"];
        $likeData = [];

        if (isset($data["query"])) {
            foreach ($like_columns as $column) {
                $likeData[$column] = $data["query"];
            }
            unset($data["query"]);
        }

        return $this->select(["item_id", "name", "brand", "description", "units.name AS units_name", "categories.name AS category_name"])
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->containsAll($likeData)
            ->and("categories.name", $data["category"] ?? "")
            ->fetchAll();
    }
}