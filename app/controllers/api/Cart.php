<?php

namespace controllers\api;

use core\Controller;

class Cart
{
    use Controller;

    public function all(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isLoggedIn()) {
                $cart = new \models\Cart();
                $this->json([
                    'status' => 'success',
                    'cart_items' => $cart->getCartItems(userId(), isGuest())
                ]);
            } else {
                $this->json([
                    'status' => 'error',
                    'message' => 'Please login to view cart'
                ]);
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function add(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $item_id = $post->id;
                    $cart = new \models\Cart();
                    $cart->addToCart(userId(), $item_id, 1, isGuest());
                    $this->json([
                        'status' => 'success',
                        'message' => 'Items added to cart',
                        'cart_count' => $cart->getNoOfItems(userId(), isGuest())
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
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $item_id = $post->id;
                $cart = new \models\Cart();
                $cart->deleteFromCart(userId(), $item_id, isGuest());
                $this->json([
                    'status' => 'success',
                    'message' => 'Items deleted from cart',
                    'cart_count' => $cart->getNoOfItems(userId(), isGuest())
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
                'message' => 'Please login to delete items from cart'
            ]);
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $item_id = $post->id;
                $item_qty = $post->qty;
                $cart = new \models\Cart();
                $cart->editCartItemQty(userId(), $item_id, $item_qty, isGuest());
                $this->json([
                    'status' => 'success',
                    'message' => 'Items edited from cart',
                    'cart_count' => $cart->getNoOfItems(userId(), isGuest())
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
                'message' => 'Please login to edit items from cart'
            ]);
        }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }
}