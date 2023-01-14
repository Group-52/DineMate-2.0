<?php

/**
 * Purchases Controller
 */

class Purchases
{
    use Controller;

    private string $controller = "items";

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        $purchasemodel = new Purchase();
        $data = [];
        $data["purchases"] = $purchasemodel->getAllPurchases();
    }

    public function create(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        $data = [];
        $data["categories"] = (new Category)->select()->fetchAll();
        $data["units"] = (new Unit)->select()->fetchAll();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new Item();
            if ($item->validate($_POST)) {
                try {
                    $item->insert([
                        "name" => $_POST["name"],
                        "brand" => $_POST["brand"] ?? null,
                        "description" => $_POST["description"] ?? null,
                        "unit" => $_POST["unit"],
                        "category" => $_POST["category"] ?? null
                    ]);
                    redirect("admin/items");
                } catch (Exception $e) {
                    $data["error"] = "Unknown error.";
                }
            }
        }
        $data["controller"] = $this->controller;
        $this->view("items.create", $data);
    }
}
