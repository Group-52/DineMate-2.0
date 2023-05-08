<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Order;
use models\OrderDishes;

class Orders
{
    use Controller;

    public function index(): void
    {
        $order = new Order;
        $od = new OrderDishes();
        $ol = $order->getTodayChefOrders();
        $dish_list = [];
        foreach ($ol as $o) {
            $dish_list[$o->order_id] = $od->getOrderDishes($o->order_id);
        }

        $data['order_list'] = $ol;
        $data['order_dishes'] = $dish_list;
        $data['controller'] = "orders";
        $this->view('admin/order.chef', $data);
    }

    public function edit($order_id): void
    {
        $order = new Order;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $order = new Order;
            $order->editOrder($_POST);
            redirect('admin/orders');
        }else
            redirect('admin/_404');
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['allDishes'] = (new Dish())->getDishes();
        $data['dishes'] = $order->getDishes($order_id);
        $data['order'] = $order->getOrder($order_id);
        $data['promo_list'] = (new \models\Promotion())->getValidPromotions($order_id);
        $data['controller'] = "orders";
        if ($data['order'])
            $this->view('admin/order.detail', $data);
        else
            redirect('admin/_404');
    }

    public function delete($order_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            (new Order)->deleteOrder($order_id);
        redirect('admin/orders');
    }

    public function history(): void
    {
        $order = new Order;
        $p = $_GET['page'] ?? 1;
        $totalPages = $order->getPages();
        if ($p > $totalPages ||$p==0) {
            redirect('admin/_404');
        } else {
            $ol = $order->getAllOrders($p);
            $data = [
                'currentPage' => $p,
                'totalPages' => $totalPages,
                'order_list' => $ol,
                'controller' => "orders"
            ];
            $this->view('admin/order.history', $data);
        }
    }
}

