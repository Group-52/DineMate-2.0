<?php

// Dish class

class Dish extends Model
{

    public function __construct()
    {
        $this->table = "dishes";
        $this->columns = [
            "name",
            "net_price",
            "selling_price",
            "description",
            "prep_time",
            "image_url"
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
     * Get all dishes.
     */
    public function getDishes(): bool|array
    {
        return $this->select()->fetchAll();
    }

    /**
     * Add a dish.
     * @param $data
     * @return void
     */
    public function addDish($data): void
    {
        $this->insert($data);
    }
}

