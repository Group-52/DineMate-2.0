<?php

namespace controllers;

use core\Controller;

class Checkout
{
    use Controller;

    public function index(): void
    {
        if (isset($_SESSION["user"])) {
            $cart = new \models\Cart();
            if ($cart->getNoOfItems() == 0) redirect("cart");
            $data["cart"] = $cart->getCartItems();
            $data["title"] = "Checkout";
            $this->view("checkout", $data);
        } else {
            redirect("login");
        }
    }
}
