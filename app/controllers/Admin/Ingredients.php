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
        $data = [
            'ingredients' => (new Item())->getItems(),
            'units' => (new Unit())->getUnits(),
            'controller' => 'ingredients',
            'dishes' => $d->getdishes()
        ];

        $dish = $_GET['d'] ?? null;

        if ($dish) {
            $data['dish'] = $d->getDishById($dish);
            if ($data['dish']) {
                $data['dishIngredients'] = (new Ingredient)->getDishIngredients($dish);
                $this->view('admin/ingredients.detail', $data);
            } else {
                redirect('admin/404');
            }
        } else {
            $this->view('admin/ingredients', $data);
        }
    }
}