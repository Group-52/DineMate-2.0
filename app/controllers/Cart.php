<?php

namespace controllers;

use core\Controller;
use models\GeneralDetails;

class Cart
{
    use Controller;

    public function index(): void
    {
        if (isLoggedIn()) {
            $cart = new \models\Cart();
            $data["cart_items"] = $cart->getCartItems(userId(), isGuest());
            $data["title"] = "Cart";
            $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
            $this->view("cart", $data);
        } else {
            redirectToLogin();
        }
    }

    public function add(): void
    {
        if (isLoggedIn()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $item_id = $_POST["dish_id"];
                $qty = $_POST["quantity"] ?? 1;
                $cart = new \models\Cart();
                $maxGuest = (new GeneralDetails())->getDetails()->max_guest_bill;

                if (isGuest() && ($cart->calculateSubTotal(userid(), true) + (new \models\Dish)->getDishById($item_id)->selling_price * $qty) >= $maxGuest) {
                    redirect("cart");
                } else {
                    if ((new \models\Dish)->safeToAdd($item_id))
                        $cart->addToCart(userId(), $item_id, $qty, isGuest());
                }
            }
            redirect("cart");
        } else {
            redirectToLogin();
        }
    }

    public function clear(): void
    {
        if (isLoggedIn()) {
            $cart = new \models\Cart();
            $cart->clearCart(userId(), isGuest());
            redirect("cart");
        } else {
            redirectToLogin();
        }
    }
}