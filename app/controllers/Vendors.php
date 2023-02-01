<?php

namespace controllers\admin;

use core\Controller;
use Exception;
use models\Vendor;
// use models\Item;
// use models\Unit;

/**
 * Items Controller
 */
class Vendors
{
    use Controller;

    private string $controller = "vendors";

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        }
        $data = [];
        // $data["items"] = (new Item())->itemsSearch($_GET);
        // $data["categories"] = (new Category())->select()->fetchAll();
        // $data["query"] = $_GET["query"] ?? "";
        // $data["category_name"] = $_GET["category"] ?? "";

        $data["controller"] = $this->controller;
        $this->view("admin/vendor", $data);
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
        // $data["categories"] = (new Category())->select()->fetchAll();
        // $data["units"] = (new Unit())->select()->fetchAll();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new vendor();
            if ($item->validate($_POST)) {
                try {
                    $item->insert([
                        "name" => $_POST["name"],
                        "address" => $_POST["address"] ?? null,
                        "company" => $_POST["company"] ?? null,
                        "contact_no" => $_POST["contact_no"]
                    ]);
                    redirect("admin/vendors");
                } catch (Exception $e) {
                    $data["error"] = "Unknown error.";
                }
            }
        }
        $data["controller"] = $this->controller;
        $this->view("admin/vendor.add", $data);
    }
}
