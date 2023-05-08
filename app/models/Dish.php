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
            "image_url",
            "veg",
            "deleted"
        ];
    }

    /**
     * Get all dishes.
     */
    public function getDishes(): bool|array
    {
        $l = $this->select()->where("deleted", 0)->orderBy("dish_name")->fetchAll();
        $dishes = [];
        foreach ($l as $d) {
            $dishes[$d->dish_id] = $d;
        }
        return $dishes;
    }

    #get dish by id
    public function getDishById($id): bool|object
    {
        return $this->select()->where("dish_id", $id)->and("deleted", 0)->fetch();
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
            'image_url' => $data['image_url'],
            'veg' => $data['veg']
        ]);
    }

    /**
     * Check if dish is safe to add to an order. i.e. if it has any ingredients where the stock is below buffer level.
     * @param $dish_id
     * @return bool
     */
    public function safeToAdd($dish_id): bool
    {
        $temp1 = (new Inventory())->getBufferItems();
        $riskstockids = [];
        foreach ($temp1 as $t) {
            $riskstockids[] = $t->item_id;
        }
        $temp2 = (new Ingredient())->getDishIngredients($dish_id);
        //If dish has no ingredients, it is safe to add
        if (count($temp2) == 0) {
            return true;
        }
        $ingids = [];
        foreach ($temp2 as $t) {
            $ingids[] = $t->item_id;
        }

        $result = array_intersect($riskstockids, $ingids);
        if (count($result) > 0) {
            return false;
        } else {
            return true;
        }

    }

    public function searchDishes($data): array
    {
        $query = $this->select();
        $and = false;
        if (isset($data['name'])) {
            $query->contains(["dish_name"], $data['name']);
            $and = true;
        }
        if (isset($data['price'])) {
            if ($and) {
                $query->and("selling_price", $data['price'], "<=");
            } else {
                $query->where('selling_price', $data['price'], "<=");
            }
        }
        if (isset($data['pref']) && $data['pref'] != 2) {
            if ($and) {
                $query->and("veg", $data['pref']);
            } else {
                $query->where("veg", $data['pref']);
            }
        }
        return $query->fetchAll();
    }

    public function updateDish($data): void
    {
        $this->update([
            'dish_name' => $data['name'],
            'net_price' => $data['net_price'],
            'selling_price' => $data['selling_price'],
            'description' => $data['description'],
            'prep_time' => $data['prep_time'],
            'veg' => $data['veg']
//            'image_url' => $data['image_url']
        ])->where('dish_id', $data['dish_id'])->execute();
    }

    public function deleteDish($id): void
    {
        $this->update(["deleted" => 1])->where('dish_id', $id)->execute();
    }

    public function minPrice(): float
    {
        return $this->min("selling_price")->fetch()->selling_price;
    }

    public function maxPrice(): float
    {
        return $this->max("selling_price")->fetch()->selling_price;
    }
}

