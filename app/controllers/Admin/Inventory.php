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
        $p = $_GET['page'] ?? 1;
        $totalPages = $inv->getInventoryCount();

        $inventory = $inv->getInventory($p);
        $this->view('admin/inventory', ['inventory' => $inventory, 'controller' => 'inventory','currentPage'=>$p,'totalPages'=>$totalPages]);
    }

    public function info(): void
    {
        $inv2 = new InventoryDetail();
        $inventory2 = $inv2->getInventory();
        $this->view('admin/inventory2', ['inventory2' => $inventory2, 'controller' => 'inventory2']);
    }

}
