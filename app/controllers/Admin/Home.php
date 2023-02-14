<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Item;

class Home
{
    use Controller;

    public function index(): void
    {
        $d = new Dish();
        $dishes = $d->getDishes();

        $items = new Item();
        $ingredients = $items->getItems();
        $expiring = (new \models\InventoryDetail())->expiring(2);
        $lowstock = (new \models\Inventory())->getReorderItems();

        $this->view('admin/dashboard', ['dishes' => $dishes, 'expiringitems' => $expiring, 'lowstockitems' => $lowstock]);
    }

}