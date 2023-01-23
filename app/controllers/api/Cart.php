<?php

namespace controllers\api;

use core\Controller;

class Cart
{
    use Controller;

    public function add(): void
    {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $item_id = $post->id;
                $user_id = $_SESSION['user']->user_id;
                $cart = new \models\Cart();
                $cart->addCart($user_id, $item_id);
                $this->json([
                    'status' => 'success',
                    'message' => 'Item added to cart',
                    'cart_count' => $cart->getNoOfItems($user_id)
                ]);
            } catch (\Exception $e) {
                $this->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Please login to add items to cart'
            ]);
        }
    }
}