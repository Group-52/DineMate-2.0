<?php

namespace controllers\api;

use core\Controller;
use models\Dish;

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
                    if ((new Dish)->safeToAdd($item_id))
                    {
                        $cart->addToCart(userId(), $item_id, 1, isGuest());
                        $this->json([
                            'status' => 'success',
                            'message' => 'Items added to cart',
                            'cart_count' => $cart->getNoOfItems(userId(), isGuest())
                        ]);
                    } else {
                        $this->json([
                            'status' => 'error',
                            'message' => 'Item is not available'
                        ]);
                    }
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

    public function cashierAdd(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $dish_id = $post->dish_id;
                    $user_id = $post->user_id;
                    $qty = $post->qty;
                    $isGuest = $post->utype == 'guest';
                    $cart = new \models\Cart();
                    $cart->addToCart($user_id, $dish_id, $qty, $isGuest);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Items added to cart',
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
    public function cashierDelete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $dish_id = $post->dish_id;
                    $user_id = $post->user_id;
                    $isGuest = $post->utype == 'guest';
                    $cart = new \models\Cart();
                    $cart->deleteFromCart($user_id, $dish_id, $isGuest);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Items deleted from cart'.$dish_id." ".$user_id." ".$isGuest,
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
    public function cashierUpdate():void{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $dish_id = $post->dish_id;
                    $user_id = $post->user_id;
                    $qty = $post->qty;
                    $isGuest = $post->utype == 'guest';
                    $cart = new \models\Cart();
                    $cart->editCartItemQty($user_id, $dish_id, $qty, $isGuest);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Items edited from cart',
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
    public function cashierGet():void{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $user_id = $post->user_id;
                    $isGuest = $post->utype == 'guest';
                    $cart = new \models\Cart();
                    $cart->getCartItems($user_id, $isGuest);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Cart items of user '.$user_id.' fetched successfully',
                        'cart_count' => $cart->getCartItems($user_id, $isGuest)
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


}