<?php

namespace controllers;

use core\Controller;

/**
 * 404 Controller
 */
class _404
{
    use Controller;

    public function index(): void
    {
        $data["title"] = "404 Not Found";
        $this->view("404", $data);
    }
}