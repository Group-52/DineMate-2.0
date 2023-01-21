<?php

namespace controllers\admin;

use core\Controller;

/**
 * Admin Controller
 */
class Home
{
    use Controller;

    private string $controller = "home";

    public function index(): void
    {
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        } else if (!isset($_SESSION["user"]->role)) {
            redirect("home");
        }
        $data = [];
        $data["controller"] = $this->controller;
        $this->view("admin/home", $data);
    }
}