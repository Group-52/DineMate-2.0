<?php

namespace controllers;

use core\Controller;

class Cart
{
    use Controller;

    public function index(): void
    {
        if (isLoggedIn()) {
            $cart = new \models\Cart();
            $data["cart_items"] = $cart->getCartItems(userId(), isGuest());
            $data["title"] = "Cart";
            $this->view("cart", $data);
        } else {
            redirect("auth");
        }
    }

    public function add(): void
    {
        if (isLoggedIn()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $item_id = $_POST["dish_id"];
                $qty = $_POST["quantity"] ?? 1;
                $cart = new \models\Cart();
                $cart->addToCart(userId(), $item_id, $qty, isGuest());
            }
            redirect("cart");
        } else {
            redirect("auth");
        }
    }

    public function clear(): void
    {
        if (isLoggedIn()) {
            $cart = new \models\Cart();
            $cart->clearCart(userId(), isGuest());
            redirect("cart");
        } else {
            redirect("auth");
        }
    }
}