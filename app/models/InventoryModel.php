<?php

/**
 * Inventory Model
 */

class InventoryModel extends Model
{
    public function __construct()
    {
        $this->table = "inventory";
        $this->columns = [
            'item_id',
            'amount_remaining',
            'last_updated',
            'max_stock_level',
            'buffer_stock_level',
            'lead_time'            
        ];
    }

    // Get all inventory data from database
    public function getInventory()
    {
        return $this->select(["inventory.*", "items.item_name"])
        ->join("items", "items.item_id", "inventory.item_id")    
        ->fetchAll();

    }

}