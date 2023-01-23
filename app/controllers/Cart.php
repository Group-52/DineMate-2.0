<?php

namespace controllers;

use core\Controller;

class Cart
{
    use Controller;

    public function index(): void
    {
        if (isset($_SESSION['user'])) {
            $id = $_SESSION['user']->user_id;
            $cart = new \models\Cart();
            $data['cart_items'] = $cart->getCart($id);
            $this->view('cart', $data);
        }
    }
}