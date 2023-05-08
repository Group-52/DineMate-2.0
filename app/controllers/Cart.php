<?php

namespace controllers;

use core\Controller;
use Exception;
use JetBrains\PhpStorm\NoReturn;
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

    /**
     * @throws Exception
     */
    #[NoReturn] public function add(): void
    {
        if (isLoggedIn()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $item_id = $_POST["dish_id"];
                $qty = $_POST["quantity"] ?? 1;
                try {
                    $cart = new \models\Cart();
                    $maxGuest = (new GeneralDetails())->getDetails()->max_guest_bill;

                    // Checking if the guest's total bill exceeds the maximum allowed
                    if (isGuest() && ($cart->calculateSubTotal(userid(), true) + (new \models\Dish)->getDishById($item_id)->selling_price * $qty) >= $maxGuest) {
                        throw new Exception("Maximum bill for guests is LKR. " . $maxGuest);
                    } else {

                        // Check if stocks are available
                        if ((new \models\Dish)->safeToAdd($item_id))
                            $cart->addToCart(userId(), $item_id, $qty, isGuest());
                        else
                            throw new Exception("This item is not available at the moment.");
                    }
                } catch (Exception $e) {
                    $_SESSION["error"] = $e->getMessage();
                }
            }
            redirect("cart");
        } else {
            redirectToLogin();
        }
    }

    #[NoReturn] public function clear(): void
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