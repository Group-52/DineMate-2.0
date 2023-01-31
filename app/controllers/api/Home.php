<?php

namespace controllers\api;

use core\Controller;

class Home
{
    use Controller;

    private string $controller = "home";

    public function index(): void
    {
        $this->json([
            'status' => 'success',
            'message' => 'API Home'
        ]);
    }
}
