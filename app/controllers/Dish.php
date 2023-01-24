<?php

namespace controllers;

use core\Controller;

class Dish
{
    use Controller;

    public function id(int $item_id): void
    {
        $data = [];
        $dish = (new \models\Dish())->getDishById($item_id);
        if ($dish) {
            $data["dish"] = $dish;
            $data["title"] = $dish->dish_name;
            $this->view("dish", $data);
        } else {
            redirect("404");
        }
    }
}