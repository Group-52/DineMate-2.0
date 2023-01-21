

<?php

class Inventory
{
    use Controller;

    public function index()
    {
        $inv = new InventoryModel();
        $inventory = $inv->getInventory();
        $this->view('inventory', ['inventory' => $inventory]);
    }

}