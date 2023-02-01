<?php

/**
 * Ingredient Model
 */

class IngredientModel extends Model
{
    public function __construct()
    {
        $this->table = "ingredients";
        $this->columns = [
            "item_id",
            "dish_id",
            "quantity",
            "unit"
        ];
    }

    // add ingredient to dish
    public function addIngredient($dish, $item, $quantity, $unit)
    {
        $data = [
            "item_id" => $item,
            "dish_id" => $dish,
            "quantity" => $quantity,
            "unit" => $unit
        ];
        return $this->insert($data);
    }

    // get ingredients of a dish
    public function getIngredients($dish)
    {
        return $this->select(["ingredients.*", "items.item_name", "units.unit_name","dishes.dish_name"])
            ->join("items", "items.item_id", "ingredients.item_id")
            ->join("units", "ingredients.unit", "units.unit_id")
            ->join("dishes", "dishes.dish_id", "ingredients.dish_id")
            ->where("ingredients.dish_id", $dish)
            ->fetchAll();
    }

    // get all dishes that use an ingredient
    public function getdishes($item)
    {
        return $this->select(["ingredients.*", "items.item_name", "units.unit_name","dishes.dish_name"])
            ->join("items", "items.item_id", "ingredients.item_id")
            ->join("units", "ingredients.unit", "units.unit_id")
            ->join("dishes", "dishes.dish_id", "ingredients.dish_id")
            ->where("ingredients.item_id", $item)
            ->fetchAll();
    }
}