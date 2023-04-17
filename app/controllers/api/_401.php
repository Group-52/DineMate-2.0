<?php

namespace controllers\api;

use core\Controller;

/**
 * 401 Controller
 */
class _401
{
    use Controller;

    public function index(): void
    {
        $this->json([
            'status' => 'error',
            'message' => '401 Not Authorized'
        ]);
    }
}