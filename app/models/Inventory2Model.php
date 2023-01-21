<?php

/**
 * Inventory 2 Model
 *  This database table corresponds to all the purchases and corresponding reductions in stock
 */

class Inventory2Model extends Model
{
    public function __construct()
    {
        $this->table = "inventory2";
        $this->columns = [
            'pid',
            'item_id',
            'amount_remaining',
            'special_notes',
            'expiry_risk',
            'last_used'
        ];
    }


    // Get all inventory data from database
    public function getInventory()
    {
        return $this->select(["inventory2.*", "items.item_name"])
        ->join("items", "items.item_id", "inventory2.item_id")    
        ->fetchAll();
    }

}