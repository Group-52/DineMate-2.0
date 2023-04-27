<?php

namespace models;

use core\Model;

/**
 * Inventory2 Model
 *  This database table corresponds to all the purchases and corresponding reductions in stock
 */
class InventoryDetail extends Model
{
    protected int $nrows=9;
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

    // get a single inventory item
    public function getInventoryItem($pid): object|bool
    {
        return $this->select(["inventory2.*", "items.item_name", "units.*"])
            ->join("items", "items.item_id", "inventory2.item_id")
            ->join("units", "items.unit", "units.unit_id")
            ->where("pid", $pid)
            ->fetch();
    }
    // get all batches with given itemid and order by date and remove a given amount from the oldest. If the amount is greater than the amount_remaining, then remove the amount_remaining and continue with the next oldest purchase
    public function reduce($itemid, $quantity, $unitid)
    {
        $batches = $this->select(["inventory2.*", "items.item_name", "units.*", "purchases.expiry_date"])
            ->join("items", "items.item_id", "inventory2.item_id")
            ->join("units", "items.unit", "units.unit_id")
            ->join("purchases", "purchases.purchase_id", "inventory2.pid")
            ->where("inventory2.item_id", $itemid)
            ->orderBy("purchases.expiry_date", "ASC")
            ->fetchAll();

//        check if batches exist
        if (!$batches) return;


//        check if unit is the same as the unit of the item
        $u1 = $batches[0]->unit_id;
        $q2 = 0;
        if ($u1 != $unitid){
            $t1 = new UnitConversion();
            $q2 = $t1->convert($unitid, $u1, $quantity);
        }
        $quantity = $q2 ? $q2 : $quantity;

        foreach ($batches as $p) {
            if ($quantity >= $p->amount_remaining) {
                $quantity -= $p->amount_remaining;
                $this->updateInventory($p->pid, 0);
            } else {
                $this->updateInventory($p->pid, $p->amount_remaining - $quantity);
                break;
            }
        }
    }

    // Get all inventory data from database with pagination
// give 0 as a parameter to not have pagination
    public function getInventory($page=1): array
    {
        $skip = ($page - 1) * $this->nrows;
        $q = $this->select(["inventory2.*", "items.item_name", "units.*","purchases.expiry_date"])
            ->join("items", "items.item_id", "inventory2.item_id")
            ->join("units", "items.unit", "units.unit_id")
            ->join("purchases", "purchases.purchase_id", "inventory2.pid")
            ->orderBy("items.item_name");
        if (!$page)
            return $q->fetchAll();
        else
            return $q->limit($this->nrows)->offset($skip)->fetchAll();
    }

    // get non-zero inventory with items set to expire in the next x weeks or less in order of expiry date
    public function expiring($weeks): array
    {
        return $this->select(["inventory2.*", "items.item_name", "units.*", "purchases.expiry_date"])
            ->join("items", "items.item_id", "inventory2.item_id")
            ->join("units", "items.unit", "units.unit_id")
            ->join("purchases", "purchases.purchase_id", "inventory2.pid")
            ->where('inventory2.expiry_risk', 1)
            ->or("purchases.expiry_date", date("Y-m-d", strtotime("+$weeks weeks")), "<=")
            ->and ("amount_remaining", 0, ">")
            ->orderBy("purchases.expiry_date", "ASC")
            ->fetchAll();
    }

    // Make sure to give named arguments
    // Update a single inventory item
    public function updateInventory($pid, $amount = null, $notes = null, $risk = null)
    {
        $data = [];
        if ($amount !== null) {
            $data['amount_remaining'] = $amount;
        }
        if ($notes != null) {
            $data['special_notes'] = $notes;
        }
        if ($risk !== null) {
            $data['expiry_risk'] = $risk;
        }
        $this->update($data)
            ->where("pid", $pid)
            ->execute();
    }

    // delete a single inventory item
    public function deleteInventory($pid)
    {
        // Check if the amount_remaining is 0
        $temp = $this->select(["amount_remaining", "item_id"])->where("pid", $pid)->fetch();

        // Check if such row exists
        if ($temp == null) {
            return;
        }

        if ($temp->amount_remaining != 0) {
            // reduce from inventory before deleting
            $inv = new Inventory();
            $inv->adjustAmount($temp->item_id, $temp->amount_remaining, "reduce");
        }

        $this->delete()
            ->where("pid", $pid)
            ->execute();
    }

    //Get the number of non-zero batches for items
    public function getCount()
    {
        $this->query =  "SELECT item_id,COUNT(*) AS count FROM inventory2 WHERE amount_remaining > 0 GROUP BY item_id";
        $temp = $this->fetchAll();
        $data=[];
        foreach ($temp as $t){
            $data[$t->item_id] = $t->count;
        }
        return $data;
    }
}
