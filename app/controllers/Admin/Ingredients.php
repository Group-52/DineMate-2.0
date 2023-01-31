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
        $ingredientList = $ing->getAllIngredients();

        $this->view('admin/ingredients', ['ingredients' => $ingredients, 'dishes' => $dishes, 'units' => $units, 'ingredientList' => $ingredientList, 'controller' => 'ingredients']);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new Ingredient();

            $data = json_decode(file_get_contents("php://input"), true);
            $dishId = $data['dish'];
            $itemId = $data['ingredient'];
            $unitId = $data['unit'];
            $amount = $data['quantity'];

            $m->addIngredient($dishId, $itemId, $amount, $unitId);
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));

    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new Ingredient();

            $data = json_decode(file_get_contents("php://input"), true);
            $dish = $data['dish'];
            $ingredient = $data['ingredient'];

            $m->deleteIngredient($dish, $ingredient);
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

    public function edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new Ingredient();

            $data = json_decode(file_get_contents("php://input"), true);
            $dish = $data['dish'];
            $ingredient = $data['ingredient'];
            $amount = $data['quantity'];
            $unit = $data['unit'];

            $m->updateIngredient($dish, $ingredient, $amount, $unit);
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

}