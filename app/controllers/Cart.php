<?php

namespace controllers;

use core\Controller;

class Cart
{
    use Controller;

    public function index(): void
    {
        if (isset($_SESSION['user']))
            $id = $_SESSION['user']->user_id;
        $cart = new \models\Cart();
        $results['cart-list'] = $cart->getCart($id);
        $this->view('cart', $results);
    }

    public function add($userid, $itemID): void
    {
        $cart = new \models\Cart();
        $cart->addCart($userid, $itemID);///
        redirect('carts/viewcart');

    }
}