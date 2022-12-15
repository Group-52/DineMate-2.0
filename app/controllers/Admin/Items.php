<?php

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
        $data["items"] = (new Item)->itemsSearch($_GET);
        $data["categories"] = (new Category)->select()->fetchAll();
        $data["query"] = $_GET["query"] ?? "";
        $data["category_name"] = $_GET["category"] ?? "";

        $data["controller"] = $this->controller;
        $this->view("items", $data);
    }

    public function create(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new Item();
            if ($item->validate($_POST)) {
                try {
                    $item->insert([
                        "name" => $_POST["name"],
                        "brand" => $_POST["brand"] ?? null,
                        "description" => $_POST["description"] ?? null,
                        "measure" => $_POST["measure"],
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
