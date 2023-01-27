<?php

namespace models;

use core\Model;

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
        $this->insert($data);
    }

    // get ingredients of a dish
    public function getIngredients($dish): array
    {
        return $this->select(["ingredients.*", "items.item_name", "units.unit_name", "dishes.dish_name"])
            ->join("items", "items.item_id", "ingredients.item_id")
            ->join("units", "ingredients.unit", "units.unit_id")
            ->join("dishes", "dishes.dish_id", "ingredients.dish_id")
            ->where("ingredients.dish_id", $dish)
            ->fetchAll();
    }

    // get all dishes that use an ingredient
    public function getdishes($item): array
    {
        return $this->select(["ingredients.*", "items.item_name", "units.unit_name", "dishes.dish_name"])
            ->join("items", "items.item_id", "ingredients.item_id")
            ->join("units", "ingredients.unit", "units.unit_id")
            ->join("dishes", "dishes.dish_id", "ingredients.dish_id")
            ->where("ingredients.item_id", $item)
            ->fetchAll();
    }

    // update an ingredient
    public function updateIngredient($dish, $item, $quantity = null, $unit = null)
    {
        $data = [];
        if ($quantity) {
            $data["quantity"] = $quantity;
        }
        if ($unit) {
            $data["unit"] = $unit;
        }
        $this->update($data)
            ->where("dish_id", $dish)
            ->and("item_id", $item)
            ->execute();
    }

    // get all ingredients of each dish
    public function getAllIngredients(): array
    {
        $l = $this->select(["ingredients.*", "items.item_name", "units.unit_name", 'units.unit_id'])
            ->join("items", "items.item_id", "ingredients.item_id")
            ->join("units", "ingredients.unit", "units.unit_id")
            ->fetchAll();
        $ingredientlist = [];
        foreach ($l as $i) {
            $ingredientlist[$i->dish_id][] = $i;
        }
        return $ingredientlist;
    }

    // delete an ingredient
    public function deleteIngredient($dish, $ingredient)
    {
        return $this->delete()
            ->where("item_id", $ingredient)
            ->and("dish_id", $dish)
            ->execute();
    }
}