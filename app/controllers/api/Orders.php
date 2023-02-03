<?php

namespace controllers\api;

use core\Controller;
use models\Order;

class Orders
{
    use Controller;

    public function index(): void
    {
        // implement later
        return;

    }

    public function update(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $od = new Order();
            $od->editOrder($_POST);
            $this->json([
                'status' => 'success'
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }
}