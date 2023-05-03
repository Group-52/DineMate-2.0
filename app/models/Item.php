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
            "image_url"
        ];
    }

    /**
     * Validate item data.
     * @param array $data
     * @return bool
     */
    public function isValid(array $data): bool
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
        $like_columns = ["items.item_name","items.description", "units.unit_name", "categories.category_name"];

        return $this->select(["item_id", "item_name", "description", "units.unit_name AS units_name", "categories.category_name AS category_name"])
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->contains($like_columns, $data["search"] ?? "")
            ->and("categories.category_name", $data["category"] ?? "")
            ->fetchAll();
    }

    public function getItems(): array
    {
<<<<<<< HEAD
        return $this->select(["item_id", "item_name", "description", "units.abbreviation, categories.category_name"])
=======
        return $this->select(["item_id", "item_name","image_url", "description","units.abbreviation", "units.unit_name AS units_name","categories.category_name"])
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
            ->join("units", "unit", "unit_id")
            ->join("categories", "category", "category_id")
            ->orderBy("item_name")
            ->fetchAll();
    }

    public function getItemById($id): bool|object
    {
        return $this->select(["item_id", "item_name", "description", "unit", "category","image_url"])
            ->where("item_id", $id)
            ->fetch();
    }
    public function addItem($name, $unit, $category, $description=null, $image_url=null):void
    {
        $data = [
            "item_name" => $name,
            "description" => $description,
            "unit" => $unit,
            "category" => $category,
            "image_url" => $image_url
        ];
        //remove keys with null values
        $data = array_filter($data, fn($v) => !is_null($v));
        $this->insert($data);
    }

}