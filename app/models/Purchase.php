<?php

namespace models;

use core\Model;

/**
 * Purchase Model
 */
class Purchase extends Model
{
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
    public function addPurchase(array $data)
    {
        $this->insert([
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
        ]);
    }

    // Get all purchase data from database
    public function getAllPurchases(): array
    {
        return $this->select(["purchases.purchase_id", "purchases.purchase_date", "vendors.vendor_name", "items.item_name", "purchases.quantity", "purchases.brand", "purchases.expiry_date", "purchases.cost", "purchases.discount", "purchases.final_price", "purchases.tax","units.*"])
            ->join("vendors", "vendor", "vendor_id")
            ->join("items", "item", "item_id")
            ->join("units", "items.unit", "unit_id")
            ->fetchAll();
    }

}