<?php

namespace controllers\api;

use core\Controller;

/**
 * 404 Controller
 */
class _404
{
    use Controller;

    public function index(): void
    {
        $this->json([
            'status' => 'error',
            'message' => '404 Not Found'
        ]);
    }
}