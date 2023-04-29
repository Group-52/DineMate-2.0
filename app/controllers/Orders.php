<?php

namespace controllers;

use Core\Controller;
use models\Order;

class Orders
{
    use Controller;

    public function index(): void
    {
        redirect("orders/active");
    }

    public function active(): void
    {
        if (isset($_SESSION["user"])) {
            $order = new Order();
            $data["orders"] = $order->getActiveOrders();
            $od = new \models\OrderDishes();
            $data["orderDish"] = [];
            foreach ($data["orders"] as $order) {
                $data["orderDishes"][$order->order_id] = $od->getOrderDishes($order->order_id);
            }
            $data["title"] = "Active Orders";
            $this->view("orders.active", $data);
        } else {
            redirect("auth");
        }
    }
}