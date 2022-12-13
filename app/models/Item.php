<?php

/**
 * Item Model
 */

class Item extends Model
{
    public function __construct()
    {
        $this->table = "items";
        $this->primary_key = "id";
        $this->columns = [
            "name",
            "brand",
            "description",
            "measure",
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
        if (empty($data["measure"])) {
            $this->errors["measure"] = "Measure is required.";
        }
        return empty($this->errors);
    }

    // TODO generalize this method

    /**
     * Get a record by multiple columns with LIKE for a category
     * @param array $data
     * @param string $category_name
     * @param string $category_column
     * @return false|array
     */
    public function findLikeCategory(array $data, string $category_name, string $category_column): false|array
    {
        try {

            $query = "SELECT * FROM $this->table WHERE ";
            $params = [];

            foreach ($data as $key => $value) {
                $query .= "$key LIKE ? OR ";
                $params[] = "%$value%";
            }

            $query = rtrim($query, "OR ");
            $query .= " AND $category_column = ?";
            $params[] = $category_name;
            $query .= " LIMIT $this->limit OFFSET $this->offset";

            return $this->query($query, $params);

        } catch (Exception) {
            $this->errors[] = "Unknown error.";

        }
        return false;
    }
}