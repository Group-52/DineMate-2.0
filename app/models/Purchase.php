<?php

namespace models;

use core\Model;

/**
 * Purchase Model
 */
class Purchase extends Model
{
    protected int $nrows = 30;

    public function __construct()
    {
        $this->table = "purchases";
        $this->columns = [
            "purchase_id",
            "purchase_date",
            "vendor",
            "item",
            "quantity",
            "brand",
            "expiry_date",
            "cost",
            "discount",
            "final_price",
            "tax"
        ];
    }

    // Insert purchase data into database
    public function addPurchase(array $data): void
    {
        $data = [
            "purchase_date" => $data["purchase_date"],
            "vendor" => $data["vendor"],
            "item" => $data["item"],
            "quantity" => $data["quantity"],
            "brand" => $data["brand"],
            "expiry_date" => $data["expiry_date"],
            "cost" => $data["cost"],
            "discount" => $data["discount"],
            "final_price" => $data["final_price"],
            "tax" => $data["tax"]
        ];
        //filter out empty and null values
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== "";
        });
        $this->insert($data);
        $pid = $this->lastInsertId();

        //update inventory tables
        $im = new Inventory();
        $im2 = new InventoryDetail();
        //check if exists
        if ($im->checkInventory($data["item"])) {
            $im->adjustAmount($data["item"], $data["quantity"], "add");
        }
        else {
            $existing = $im2->getQuantity($data["item"]);
            $im->add($data["item"], $data["quantity"]+$existing);
        }
        $im2->add($pid, $data["item"], $data["quantity"]);

    }

//  Update purchase data in database
    public function updatePurchase($id, array $data): void
    {
        $this->update($data)
            ->where("purchase_id", $id)
            ->execute();

        //update inventory2 if quantity is updated
        if (isset($data["quantity"])) {
            $inv2 = new InventoryDetail();
            $inv2->updateInventory($id, $amount = $data["quantity"]);
        }
    }

    // Delete purchase data from database
    public function deletePurchase($id): void
    {
        $this->delete()
            ->where("purchase_id", $id)
            ->execute();
//        if respective inventory2 record exists, delete it
        $inv2 = new InventoryDetail();
        $inv2->deleteInventory($id);
    }

    // Get all purchase data from database with pagination
    // give 0 as a parameter to not have pagination
    public function getAllPurchases($page = 1): array
    {
        $q = $this->select(["purchases.purchase_id", "purchases.purchase_date", "vendors.vendor_name", "items.item_name", "purchases.quantity", "purchases.brand", "purchases.expiry_date", "purchases.cost", "purchases.discount", "purchases.final_price", "purchases.tax", "units.*"])
            ->join("vendors", "vendor", "vendor_id")
            ->join("items", "item", "item_id")
            ->join("units", "items.unit", "unit_id")
            ->orderBy("purchase_date", "DESC");
        $skip = ($page - 1) * $this->nrows;
        if (!$page)
            return $q->fetchAll();
        else
            return $q->limit($this->nrows)->offset($skip)->fetchAll();
    }

    public function getAll($sd, $ed): array
    {
        $sd = date("Y-m-d H:i:s", strtotime($sd));
        $ed = date("Y-m-d H:i:s", strtotime($ed));
        return $this->select(["purchases.purchase_id", "purchases.purchase_date", "vendors.vendor_name", "items.item_name", "purchases.quantity", "purchases.brand", "purchases.expiry_date", "purchases.cost", "purchases.discount", "purchases.final_price", "purchases.tax", "units.*"])
            ->join("vendors", "vendor", "vendor_id")
            ->join("items", "item", "item_id")
            ->join("units", "items.unit", "unit_id")
            ->where("purchase_date", $sd, ">=")
            ->and("purchase_date", $ed, "<=")
            ->orderBy("purchase_date", "DESC")
            ->fetchAll();
    }

}