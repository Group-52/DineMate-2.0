<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Item;

class Home
{
    use Controller;

    public function stats(): void
    {
        $d = new Dish();
        $dishes = $d->getDishes();

        $expiring = (new \models\InventoryDetail())->expiring(2);
        $lowstock = (new \models\Inventory())->getReorderItems();

        $data = ['dishes' => $dishes, 'expiringitems' => $expiring,
            'lowstockitems' => $lowstock, 'controller' => 'home'
        ];
        $this->view('admin/dashboard', $data);
    }
    public function index(): void{
        $this->view('admin/home');
    }

    public function reports():void{
        $this->view('admin/reports');
    }

}