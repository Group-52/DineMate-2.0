<?php

/**
 * Purchases Controller
 */

class Purchases
{
    use Controller;



    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        $purchasemodel = new Purchase();
        $v = new Vendor();
        $i = new Item();
        $data = [];
        $data["purchases"] = $purchasemodel->getAllPurchases();
        $data["vendors"] = $v->getVendors();
        $data["items"] = $i->getItems();

        $this->view("purchases", $data);
    }

    public function addPurchase(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['submit'])) {
                $purchase_date = $_POST['purchase_date'];
                $vendor = $_POST['vendor'];
                $item = $_POST['item'];
                $quantity = $_POST['quantity'];
                $brand = $_POST['brand'];
                $expiry_date = $_POST['expiry_date'];
                $cost = $_POST['cost'];
                $discount = $_POST['discount'];
                $final_price = $_POST['final_price'];
                $tax = $_POST['tax'];

                $purchasemodel = new Purchase();
                $purchasemodel->addPurchase([
                    'purchase_date' => $purchase_date,
                    'vendor' => $vendor,
                    'item' => $item,
                    'quantity' => $quantity,
                    'brand' => $brand,
                    'expiry_date' => $expiry_date,
                    'cost' => $cost,
                    'discount' => $discount,
                    'final_price' => $final_price,
                    'tax' => $tax
                ]);
                redirect("admin/purchases");
                $this->view("purchases");
            }
        }
        redirect("admin/purchases");
        $this->view("purchases");
    }
}
