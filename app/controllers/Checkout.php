<?php

namespace controllers;

use core\Controller;
use components\Form;
use models\Cart;
use models\Order;
use WebSocket\Client;

class Checkout
{
    use Controller;

    public function index(): void
    {
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
                }
            } else {
                $data["errors"] = $form->getErrors();
            }
        }
        $data["form"] = $form;
        $data["cart"] = $cartItems;
        $this->view("checkout", $data);
    }
}
