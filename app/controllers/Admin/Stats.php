<?php

namespace controllers\admin;

use core\Controller;
use models\Menu;
use models\MenuDishes;
use models\Dish;

/**
 * Statistics Class
 */
class Stats
{
    use Controller;

    public function index(): void
    {
        $expiring = (new \models\InventoryDetail())->expiring(2);
        $lowstock = (new \models\Inventory())->getReorderItems();

        $data =[
            'controller' => 'stats',
            'expiringitems' => $expiring,
            'lowstockitems' => $lowstock
        ];
        $this->view('admin/stats', $data);
    }


}

