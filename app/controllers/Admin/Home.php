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
            redirect("login");
        }
        $data = [];
        $data["controller"] = $this->controller;
        $this->view("Admin", $data);
    }
}