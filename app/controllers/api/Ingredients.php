<?php

namespace controllers\api;

use core\Controller;
use models\Ingredient;

class Ingredients
{
    use Controller;

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->json([
                "status" => "success",
                "ingredients" => (new Ingredient())->getIngredients()
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid request"
            ]);
    }

    public  function recipe(){
        $dish = $_GET['dish'];
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->json([
                "status" => "success",
                "ingredients" => (new Ingredient())->getDishIngredients($dish)
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid request"
            ]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = json_decode(file_get_contents('php://input'));
            $dishId = $post->dish;
            $itemId = $post->ingredient;
            $unitId = $post->unit;
            $amount = $post->quantity;

            (new Ingredient())->addIngredient($dishId, $itemId, $amount, $unitId);
            $this->json([
                "status" => "success",
                "message" => "Data received successfully"
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid request"
            ]);

    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $dish = $data->dish;
            $ingredient = $data->ingredient;

            (new Ingredient())->deleteIngredient($dish, $ingredient);
            $this->json([
                "status" => "success",
                "message" => "Data received successfully"
            ]);
        } else
            $this->json(["status" => "error", "message" => "Invalid request"]);
    }

    public function edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = json_decode(file_get_contents("php://input"));
            $dish = $data->dish;
            $ingredient = $data->ingredient;
            $amount = $data->quantity;
            $unit = $data->unit;

            (new Ingredient())->updateIngredient($dish, $ingredient, $amount, $unit);
            $this->json(["status" => "success",
                "message" => "Data received successfully"
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid request"
            ]);
    }
}