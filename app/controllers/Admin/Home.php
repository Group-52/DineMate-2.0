<?php

/**
 * Admin Controller
 */

class Home
{
    use Controller;

    private string $controller = "home";

    public function index(): void
    {
        // TODO Allow access based on roles
        if (!isset($_SESSION["user"])) {
            redirect("admin/auth");
        } else if (!isset($_SESSION["user"]->role)) {
           redirect("home");
        }
        $data = [];
        $data["controller"] = $this->controller;
        $this->view("admin", $data);
    }
}