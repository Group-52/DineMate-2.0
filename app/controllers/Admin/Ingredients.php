<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Ingredient;
use models\Item;
use models\Unit;

class Ingredients
{
    use Controller;

    public function index(): void
    {
        $d = new Dish();
        $dishes = $d->getDishes();

        $items = new Item();
        $ingredients = $items->getItems();

        $u = new Unit();
        $units = $u->getUnits();

        $ing = new Ingredient();
        $ingredientList = $ing->getIngredients();

        $this->view('admin/ingredients', ['ingredients' => $ingredients, 'dishes' => $dishes, 'units' => $units, 'ingredientList' => $ingredientList]);
    }
}