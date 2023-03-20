<?php

namespace controllers\admin;

use core\Controller;
use models\InventoryDetail;

class Inventory
{
    use Controller;

    public function index(): void
    {
        $inv = new \models\Inventory();
        $inventory = $inv->getInventory();
        $this->view('admin/inventory', ['inventory' => $inventory, 'controller' => 'inventory']);
    }

    public function info(): void
    {
        $inv2 = new InventoryDetail();
        $inventory2 = $inv2->getInventory();
        $this->view('admin/inventory2', ['inventory2' => $inventory2, 'controller' => 'inventory2']);
    }

}
