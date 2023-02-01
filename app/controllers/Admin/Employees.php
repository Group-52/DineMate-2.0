<?php

namespace controllers\admin;

use core\Controller;
use Exception;
use models\Employee;
// use models\Item;
// use models\Unit;

/**
 * Items Controller
 */
class Employees
{
    use Controller;

    private string $controller = "employees";

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
        $this->view("admin/employee", $data);
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
            $employee = new employee();
            if ($employee->validate($_POST)) {
                try {
                    $employee->insert([
                        "first_name" => $_POST["first_name"],
                        "last_name" => $_POST["last_name"],
                        "role" => $_POST["role"] ?? null,
                        "salary" => $_POST["salary"] ?? null,
                        "DOB" => $_POST["DOB"] ?? null,
                        "contact_no" => $_POST["contact_no"] ?? null,
                        "NIC" => $_POST["NIC"] ?? null
                    ]);
                    redirect("admin/employees");
                } catch (Exception $e) {
                    $data["error"] = "Unknown error.";
                }
            }
        }
        $data["controller"] = $this->controller;
        $this->view("admin/employee.add", $data);
    }
}
