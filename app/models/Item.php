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
}