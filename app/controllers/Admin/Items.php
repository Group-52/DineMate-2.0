<?php

namespace controllers\admin;

use core\Controller;
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
        if (isset($_GET["query"])) {
            if (isset($_GET["category"]) && $_GET["category"] == "All") {
                unset($_GET["category"]);
            }
            $data["items"] = (new Item())->itemsSearch($_GET);
        } else {
            $data["items"] = (new Item())->getItems();
        }
        $data["categories"] = (new Category())->select()->fetchAll();
        $data["query"] = $_GET["query"] ?? "";
        $data["category_name"] = $_GET["category"] ?? "";
        $data["units"] = (new Unit())->select()->fetchAll();

        $data["controller"] = $this->controller;
        $this->view("admin/items", $data);
    }

    public function create(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new Item();
            $file = $_FILES["item-image"];
            if ($file['size'] != 0) {
                $target_dir = '../public/assets/images/items/';
                if (isImage($file) && isValidSize($file, 5000000) && isImageType($file)) {
                    // 	// Set path to store the uploaded image
                    $target_file = getFileName($_POST["name"], $file);
                    if (!move_uploaded_file($_FILES["item-image"]["tmp_name"], $target_dir . $target_file)) {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            if ($item->validate($_POST)) {
                $item->insert([
                    "item_name" => $_POST["name"],
                    "description" => $_POST["description"] ?? null,
                    "unit" => $_POST["unit"],
                    "category" => $_POST["category"] ?? 17,
                    "image_url" => $target_file ?? null
                ]);
                redirect("admin/items");
            }
        }
    }

    public function edit($id): void
    {
        $im = new Item();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST["name"];
            $description = $_POST["description"] ?? null;
            $unit = $_POST["unit"];
            $category = $_POST["category"] ?? 17;
            $image_url = $_POST["image_url"] ?? null;
show($_POST);
            $im->edit($id, $name, $unit, $category, $description, $image_url);

            redirect("admin/items");
        } else {
            $item = $im->getItemById($id);
            $data["itemx"] = $item;
            $data['controller'] = $this->controller;
            $data["categories"] = (new Category())->select()->fetchAll();
            $data["units"] = (new Unit())->select()->fetchAll();

            $this->view("admin/items.edit", $data);
        }
    }
}
