<?php

namespace controllers\api;

use core\Controller;
use models\Dish;

class Dishes
{
    use Controller;

    public function index(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $dish = new Dish();
            $this->json([
                'status' => 'success',
                'dishes' => $dish->getDishes()
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function search(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $dish = new Dish();
            $this->json([
                'status' => 'success',
                'dishes' => $dish->searchDishes($_GET)
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = json_decode(file_get_contents('php://input'), true);
            (new Dish())->deleteDish($_POST['id']);
            $this->json([
                'status' => 'success',
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function minmax(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $dish = new Dish();
            $this->json([
                'status' => 'success',
                'min' => $dish->minPrice(),
                'max' => $dish->maxPrice()
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }
}