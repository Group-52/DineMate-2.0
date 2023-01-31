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
}