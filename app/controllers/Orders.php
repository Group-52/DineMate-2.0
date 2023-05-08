<?php

namespace controllers;

use components\Pagination;
use Core\Controller;
use models\Order;
use models\OrderDishes;
use models\Promotion;

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
            $promo = new Promotion();
            $limit = 10;
            $offset = (($_GET["page"] ?? 1) - 1) * $limit;
            $data["orders"] = $order->getUncollectedOrders(userId(), $limit, $offset, isGuest());
            $this->extracted($data["orders"], $order, $promo);
            $totalCount = $order->getActiveOrdersCount(userId(), isGuest());
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
            $promo = new Promotion();
            $limit = 10;
            $offset = (($_GET["page"] ?? 1) - 1) * $limit;
            $data["orders"] = $order->getPreviousOrders(userId(), $limit, $offset, isGuest());
            $this->extracted($data["orders"], $order, $promo);
            $totalCount = $order->getPreviousOrdersCount(userId(), isGuest());
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
    private function paginateOrders(int $totalCount, int $limit, array $data): array
    {
        $data["pagination"] = new Pagination($totalCount, $_GET["page"] ?? 1, $limit);
        $od = new OrderDishes();
        $data["orderDish"] = [];
        foreach ($data["orders"] as $order) {
            $data["orderDishes"][$order->order_id] = $od->getOrderDishes($order->order_id);
        }
        return $data;
    }

    /**
     * @param $orders
     * @param Order $order
     * @param Promotion $promo
     * @return void
     */
    public function extracted($orders, Order $order, Promotion $promo): void
    {
        for ($i = 0; $i < count($orders); $i++) {
            $orders[$i]->time_remaining = $order->getTimeRemaining($orders[$i]->order_id);
            $orders[$i]->sub_total = $order->calculateSubTotal($orders[$i]->order_id);
            $orders[$i]->discount = $promo->reducedCost($orders[$i]->order_id, $orders[$i]->promo);
            $orders[$i]->total = $order->calculateFullTotal($orders[$i]->order_id);
        }
    }
}