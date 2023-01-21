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
        $this->view("404");
    }
}