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
        $totalPages = $inv->getPages();

        $inventory = $inv->getInventory($p);
        $this->view('admin/inventory', ['inventory' => $inventory, 'controller' => 'inventory','currentPage'=>$p,'totalPages'=>$totalPages]);
    }

    public function info(): void
    {
        $inv2 = new InventoryDetail();
        $p = $_GET['page'] ?? 1;
        $totalPages = $inv2->getPages();
        $inventory2 = $inv2->getInventory($p);
        $this->view('admin/inventory2', ['inventory2' => $inventory2, 'controller' => 'inventory','currentPage'=>$p,'totalPages'=>$totalPages]);
    }

    public function dashboard():void
    {
        $data = [];
        $invlist = (new \models\Inventory())->getInventoryByCategory();
        $data['controller'] = 'inventory';
        $data['invlist'] = $invlist;
        $data['batchcounts']=(new \models\InventoryDetail())->getCount();
        $this->view('admin/inventory.dashboard',$data);
    }

}
