<?php

namespace controllers;

use core\Controller;

class Cart
{
    use Controller;

    public function index(): void
    {
        if (isset($_SESSION["user"])) {
            $cart = new \models\Cart();
            $data["cart_items"] = $cart->getCartItems();
            $data["title"] = "Cart";
            $this->view("cart", $data);
        } else {
            redirect("auth");
        }
    }

    public function add(): void
    {
        if (isset($_SESSION["user"])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $item_id = $_POST["dish_id"];
                $qty = $_POST["quantity"] ?? 1;
                $user_id = $_SESSION["user"]->user_id;
                $cart = new \models\Cart();
                $cart->addToCart($user_id, $item_id, $qty);
            }
            redirect("cart");
        } else {
            redirect("auth");
        }
    }
}