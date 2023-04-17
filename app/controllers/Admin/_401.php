<?php

namespace controllers\admin;

use core\Controller;

/**
 * 401 Controller
 */
class _401
{
    use Controller;

    public function index(): void
    {
        $data["title"] = "401 Not Authorized";
        $this->view("401", $data);
    }
}