<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Ingredient;
use models\Item;
use models\Unit;

class Dashboard
{
    use Controller;

    public function index(): void
    {
        $d = new Dish();
        $dishes = $d->getDishes();

        $items = new Item();
        $ingredients = $items->getItems();

        $this->view('admin/dashboard', ['dishes' => $dishes]);
    }

}