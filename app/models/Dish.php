<?php

namespace models;

use core\Model;

/**
 * Dish class
 */
class Dish extends Model
{

    public function __construct()
    {
        $this->table = "dishes";
        $this->columns = [
            "dish_id",
            "dish_name",
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
    public function isValid(array $data): bool
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
        $l = $this->select()->orderBy("dish_name")->fetchAll();
        $dishes = [];
        foreach ($l as $d) {
            $dishes[$d->dish_id] = $d;
        }
        return $dishes;
    }

    #get dish by id
    public function getDishById($id): bool|object
    {
        return $this->select()->where("dish_id", $id)->fetch();
    }

    /**
     * Add a dish.
     * @param $data
     * @return void
     */
    public function addDish($data): void
    {
        $this->insert([
            'dish_name' => $data['name'],
            'net_price' => $data['net_price'],
            'selling_price' => $data['selling_price'],
            'description' => $data['description'],
            'prep_time' => $data['prep_time'],
            'image_url' => $data['image_url']
        ]);
    }

    public function searchDishes($data): array
    {
        $query = $this->select();
        if (isset($data['name'])) {
            $query->contains(["dish_name"], $data['name']);
        }
        if (isset($data['price'])) {
            $query->where('selling_price', '<=', $data['price']);
        }
        // TODO search by Menu
        return $query->fetchAll();
    }
}

