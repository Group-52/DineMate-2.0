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
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $status = $post->status;

                $od = new \models\Order();

                $od->changeStatus($order_id, $status);
                $this->json([
                    'status' => 'success',
                    'message' => 'Order status changed'
                ]);
            } catch (\Exception $e) {
                $this->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}