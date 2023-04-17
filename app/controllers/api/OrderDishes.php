<?php

namespace controllers\api;

use core\Controller;

class OrderDishes
{
    use Controller;

    public function index(): void
    {
        // implement later
        return;
    }
    public function add(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $order_id = $post->order_id;
                    $dish_id = $post->dish_id;
                    $quantity = $post->quantity;
                    (new \models\OrderDishes())->addOrderDish($order_id, $dish_id, $quantity);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Dish added to order'
                    ]);
                } catch (\Exception $e) {
                    $this->json([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]);
                }
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function update(): void
    {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $dish_id = $post->dish_id;
                $quantity = $post->quantity;

                (new \models\OrderDishes())->updateOrderDish($order_id, $dish_id, $quantity);
                $this->json([
                    'status' => 'success',
                    'message' => 'Order quantity updated'
                ]);
            } catch (\Exception $e) {
                $this->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function delete():void
    {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $dish_id = $post->dish_id;
                (new \models\OrderDishes())->deleteOrderDish($order_id, $dish_id);
                $this->json([
                    'status' => 'success',
                    'message' => 'Order deleted'
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
