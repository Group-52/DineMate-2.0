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
            redirect("login");
        }
        $data = [];
        $item = new Item;
        if (isset($_GET["query"]) && $_GET["query"] != "") {
            $like_columns = ["name", "description", "category", "measure"];
            foreach ($like_columns as $column) {
                $data[$column] = $_GET["query"];
            }
            if (isset($_GET["category"]) && $_GET["category"] != "") {
                $data["items"] = $item->findLikeCategory($data, $_GET["category"], "category");
            } else {
                $data["items"] = $item->findLike($data);
            }
        } else if (isset($_GET["category"]) && $_GET["category"] != "") {
            $data["items"] = $item->findBy(["category" => $_GET["category"]]);
        } else {
            $data["items"] = $item->all();
        }

        $data["controller"] = $this->controller;
        $this->view("items", $data);
    }

    public function create(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("login");
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
        $this->view("create.items", $data);
    }
}
