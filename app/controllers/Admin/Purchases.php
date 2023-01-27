<?php

namespace controllers\admin;


use core\Controller;
use models\Item;
use models\Purchase;
use models\Vendor;

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

        $purchaseModel = new Purchase();
        $v = new Vendor();
        $i = new Item();
        $data = [];
        $data["purchases"] = $purchaseModel->getAllPurchases();
        $data["vendors"] = $v->getVendors();
        $data["items"] = $i->getItems();

        $this->view("purchases", $data);
    }

    public function addPurchase(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        }
        redirect("admin/purchases");
    }
}
