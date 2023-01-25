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
            'expiryrisk',
            'last_used'
        ];
    }

    // get a single inventory item
    public function getInventoryItem($pid)
    {
        return $this->select(["inventory2.*", "items.item_name"])
        ->join("items", "items.item_id", "inventory2.item_id")
        ->where("pid", $pid)
        ->fetch();
    }


    // Get all inventory data from database
    public function getInventory()
    {
        return $this->select(["inventory2.*", "items.item_name"])
        ->join("items", "items.item_id", "inventory2.item_id")    
        ->fetchAll();
    }

    // Make sure to give named arguments
    // Update a single inventory item
    public function updateInventory($pid,$amount=null, $notes=null, $risk=null)
    {
        $data2 =[];

        if ($amount != null) {
            $data2['amount_remaining'] = $amount;
        }
        if ($notes != null) {
            $data2['special_notes'] = $notes;
        }
        if ($risk != null) {
            $data2['expiryrisk'] = $risk;
        }
        
        $this->update($data2)
        ->where("pid", $pid)
        ->execute();
    }

    // delete a single inventory item
    public function deleteInventory($pid)
    {
        // Check if the amount_remaining is 0
        $temp = $this->select(["amount_remaining","item_id"])->where("pid", $pid)->fetch();

        // Check if such row exists
        if ($temp == null) {
            return;
        }

        if ($temp->amount_remaining != 0) {
            // reduce from inventory before deleting
            $inv = new InventoryModel();
            $inv->adjustAmount($temp->item_id, $temp->amount_remaining, "reduce");
        }

        $this->delete()
        ->where("pid", $pid)
        ->execute();

    }

}