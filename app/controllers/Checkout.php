<?php

namespace controllers;

use core\Controller;
use components\Form;
use models\Cart;
use models\Order;

class Checkout
{
    use Controller;

    public function index(): void
    {
        $data = [];
        $data["title"] = "Checkout";
        $cart = new Cart();
        $form = new Form("", "POST", "Checkout");
        $form->addSelectField("order-type", "order-type", "Type of Order",true, ["dine-in" => "Dine-In", "takeaway" => "Take Away"], "Type of Order");
        $form->addInputField("schedule-order", "schedule-order", "checkbox", "Schedule Order", false, "Schedule Order", "", true);
        $form->addInputField("order-time", "order-time", "datetime-local", "Order Time", false, "Order Time", date("Y-m-d H:i"), true);
        $form->addInputField("table-number", "table-number", "number", "Table Number", false, "", "", true);
        $form->addInputField("request", "request", "text", "Request", false, "Less spicy, no salt, etc.");
        if (!isset($_SESSION["user"])) {
            $form->addInputField("full-name", "full-name", "text", "Full Name", true, "Full Name");
            $form->addInputField("mobile", "mobile", "text", "Mobile", true, "Mobile");
            $form->addInputField("email", "email", "email", "Email", true, "Email");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($form->isValid($_POST)) {
                $cart = new Cart();
                $cart_items = $cart->getCartItems();
                $order = new Order();
                $order->create($_POST["order-type"], $cart_items, $_SESSION["user"]->user_id ?? null,
                    $_POST["request"], $_POST["user_id"] ?? null, $_POST["table-number"] ?? null,
                    isset($_POST["schedule-order"]) ? $_POST["order-time"] : null);

                if ($order->getErrors()) {
                    $data["errors"] = $order->getErrors();

                } else {
                    $data["success"] = "Order placed successfully";
                    if ($_SESSION["user"])
                        $cart->clearCart($_SESSION["user"]->user_id);
                }
            } else {
                $data["errors"] = $form->getErrors();
            }
        }
        $data["form"] = $form;
        $data["cart"] = $cart->getCartItems();
        $this->view("checkout", $data);
    }
}
