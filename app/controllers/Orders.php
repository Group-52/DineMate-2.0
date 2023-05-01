<?php

namespace controllers;

use components\Pagination;
use Core\Controller;
use models\Order;
use models\OrderDishes;

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
            $limit = 10;
            $offset = (($_GET["page"] ?? 1) - 1) * $limit;
            $data["orders"] = $order->getActiveOrders($_SESSION["user"]->user_id, $limit, $offset);
            $totalCount = $order->getActiveOrdersCount($_SESSION["user"]->user_id);
            $data = $this->paginateOrders($totalCount, $limit, $data);
            $data["title"] = "Active Orders";
            $this->view("orders.active", $data);
        } else {
            redirect("auth");
        }
    }

    public function previous(): void
    {
        if (isset($_SESSION["user"])) {
            $order = new Order();
            $limit = 10;
            $offset = (($_GET["page"] ?? 1) - 1) * $limit;
            $data["orders"] = $order->getPreviousOrders($_SESSION["user"]->user_id, $limit, $offset);
            $totalCount = $order->getPreviousOrdersCount($_SESSION["user"]->user_id);
            $data = $this->paginateOrders($totalCount, $limit, $data);
            $data["title"] = "Previous Orders";
            $this->view("orders.previous", $data);
        } else {
            redirect("auth");
        }
    }

    /**
     * @param int $totalCount
     * @param int $limit
     * @param array $data
     * @return array
     */
    public function paginateOrders(int $totalCount, int $limit, array $data): array
    {
        $data["pagination"] = new Pagination($totalCount, $_GET["page"] ?? 1, $limit);
        $od = new OrderDishes();
        $data["orderDish"] = [];
        foreach ($data["orders"] as $order) {
            $data["orderDishes"][$order->order_id] = $od->getOrderDishes($order->order_id);
        }
        return $data;
    }
}