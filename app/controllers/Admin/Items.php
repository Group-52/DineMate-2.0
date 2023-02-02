<?php

namespace controllers\admin;

use core\Controller;
use Exception;
use models\Category;
use models\Item;
use models\Unit;

/**
 * Items Controller
 */
class Items
{
    use Controller;

    private string $controller = "items";

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }
        $data = [];
        $data["items"] = (new Item())->itemsSearch($_GET);
        $data["categories"] = (new Category())->select()->fetchAll();
        $data["query"] = $_GET["query"] ?? "";
        $data["category_name"] = $_GET["category"] ?? "";
        $data["units"] = (new Unit())->select()->fetchAll();

        $data["controller"] = $this->controller;
        $this->view("admin/items", $data);
    }

    public function create(): void
    {
        /** TODO
         * Add form component
         */

        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        $data = [];
        $data["categories"] = (new Category())->select()->fetchAll();
        $data["units"] = (new Unit())->select()->fetchAll();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new Item();
            if ($item->validate($_POST)) {
                try {
                    $item->insert([
                        "item_name" => $_POST["name"],
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
    }
}
