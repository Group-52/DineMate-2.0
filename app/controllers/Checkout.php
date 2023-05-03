<?php

namespace controllers;

use components\Form;
use core\Controller;
<<<<<<< HEAD
use models\Cart;
use models\Order;
=======
use components\Form;
use models\Cart;
use models\Order;
use WebSocket\Client;
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

class Checkout
{
    use Controller;

    public function index(): void
    {
<<<<<<< HEAD
        $data = [];
        $data["title"] = "Order Details";
        $cart = new Cart();
        $form = new Form("", "POST", "Checkout");
        $form->addSelectField("order-type", "order-type", ["dine-in" => "Dine-In", "takeaway" => "Take Away"], "Type of Order", true, "Type of Order");
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
                    redirect("home");
=======
        $cart = new Cart();
        $cartItems = $cart->getCartItems(userId(), isGuest());
        if (empty($cartItems)) {
            redirect("cart");
        }

        $data = [];
        $data["title"] = "Checkout";
        $form = new Form("", "POST", "Checkout");
        $form->addSelectField("order-type", "order-type", "Type of Order",true, ["dine-in" => "Dine-In", "takeaway" => "Take Away"], "Type of Order");
        if (isRegistered()) {
            $form->addInputField("schedule-order", "schedule-order", "checkbox", "Schedule Order", false, "Schedule Order", "", true);
            $form->addInputField("order-time", "order-time", "datetime-local", "Order Time", false, "Order Time", date("Y-m-d H:i"), true);
        }
        $form->addInputField("table-number", "table-number", "number", "Table Number", false, "", "", true);
        $form->addInputField("request", "request", "text", "Request", false, "Less spicy, no salt, etc.");
        if (isGuest()) {
            $form->addInputField("full-name", "full-name", "text", "Full Name", true, "Full Name");
            $form->addInputField("mobile", "mobile", "text", "Mobile", true, "Mobile");
            $form->addInputField("email", "email", "email", "Email", true, "Email");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($form->isValid($_POST)) {
                $cart = new Cart();
                $cart_items = $cart->getCartItems(userId(), isGuest());
                $order = new Order();
                $order_id = $order->create($_POST["order-type"], $cart_items, reg_customer_id: (isRegistered()) ? userId() : null,
                    guest_id: (isGuest()) ? userId() : null, request: $_POST["request"], table_id: $_POST["table-number"] ?? null,
                    scheduled_time: isset($_POST["schedule-order"]) ? $_POST["order-time"] : null);

                if ($order->getErrors()) {
                    $data["errors"] = $order->getErrors();
                    $data["error"] = "Order could not be placed";
                } else {
                    $data["success"] = "Order placed successfully";

                    $ws = new Client("ws://" . SOCKET_HOST . ":8080");
                    $ws->text(json_encode([
                        "event_type" => "new_order",
                        "data" => [
                            "order_id" => $order_id,
                            "status" => "pending",
                            "time_placed" => date("Y-m-d H:i:s"),
                            "request" => $_POST["request"],
                            "user_id" => userId(),
                            "user_type" => (isRegistered()) ? "registered" : "guest",
                            "type" => $_POST["order-type"],
                            "scheduled_time" => $_POST["schedule-order"] ?? null,
                            "table_id" => $_POST["table-number"] ?? null,
                            "order_dishes" => $cart_items
                        ]
                    ]));
                    if ($_SESSION["user"])
                        $cart->clearCart(userId(), isGuest());
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
                }
            } else {
                $data["errors"] = $form->getErrors();
            }
        }
        $data["form"] = $form;
<<<<<<< HEAD
        $data["cart"] = $cart->getCartItems();
=======
        $data["cart"] = $cartItems;
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
        $this->view("checkout", $data);
    }
}
