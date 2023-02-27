<?php

namespace models;

use core\Model;

/**
 * Inventory Model
 */
class Inventory extends Model
{
    public int $nrows=5;
    public function __construct()
    {
        $this->table = "inventory";
        $this->columns = [
            'item_id',
            'amount_remaining',
            'last_updated',
            'max_stock_level',
            'buffer_stock_level',
            'reorder_level',
            'lead_time'
        ];
    }

    // Get all inventory data from database
    public function getInventory($page=1): array
    {
        $skip = ($page - 1) * $this->nrows;
        return $this->select(["inventory.*", "items.item_name", "units.abbreviation"])
            ->join("items", "items.item_id", "inventory.item_id")
            ->join("units", "units.unit_id", "items.unit")
            ->limit($this->nrows)
            ->offset($skip)
            ->fetchAll();
    }
    public function getInventoryCount()
    {
         $crow = $this->count('item_id')->fetch();
         return ceil($crow->{'COUNT(item_id)'}/($this->nrows));
    }

    // Get items that are below the reorder level
    public function getReorderItems(): array
    {
        return $this->select(["inventory.*", "items.item_name", "units.abbreviation"])
            ->join("items", "items.item_id", "inventory.item_id")
            ->join("units", "units.unit_id", "items.unit")
            ->wherecolumn("inventory.amount_remaining", "inventory.reorder_level","<=")
            ->fetchAll();
    }

    //  Get items that are below the buffer level
    public function getBufferItems(): array
    {
        return $this->select(["inventory.*", "items.item_name", "units.abbreviation"])
            ->join("items", "items.item_id", "inventory.item_id")
            ->join("units", "units.unit_id", "items.unit")
            ->wherecolumn("amount_remaining", "buffer_stock_level","<=")
            ->fetchAll();
    }

    // update inventory
    public function updateInventory($item, $amount = null, $max = null, $buffer = null, $lead = null, $reorder = null)
    {
        $data = [];
        if ($amount) {
            $data["amount_remaining"] = $amount;
        }
        if ($max) {
            $data["max_stock_level"] = $max;
        }
        if ($buffer) {
            $data["buffer_stock_level"] = $buffer;
        }
        if ($reorder) {
            $data["reorder_level"] = $reorder;
        }
        if ($lead) {
            $data["lead_time"] = $lead;
        }
        $this->update($data)
            ->where("item_id", $item)
            ->execute();
    }

    // reduce or add to inventory
    public function adjustAmount($item, $amount, $operation)
    {
        $current = $this->select(["amount_remaining"])->where("item_id", $item)->fetch();
        $current = $current->amount_remaining;
        if ($operation == "add") {
            $this->update(["amount_remaining" => $current + $amount])
                ->where("item_id", $item)->execute();
        } else if ($operation == "reduce") {
            $this->update(["amount_remaining" => $current - $amount])
                ->where("item_id", $item)->execute();
        }
    }
}
