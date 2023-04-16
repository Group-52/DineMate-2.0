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
        $ol = $order->getValidOrders();
        $dish_list = [];
        foreach ($ol as $o) {
            $dish_list[$o->order_id] = $od->getOrderDishes($o->order_id);
        }

        $results['order_list'] = $ol;
        $results['order_dishes'] = $dish_list;
        $results['controller'] = "orders";
        $this->view('admin/order.chef', $results);
    }

    public function edit($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $order = new Order;
            $order->editOrder($_POST);
            redirect('admin/orders');
        }
        $this->view('admin/order.edit', $results);
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['allDishes'] = (new Dish())->getDishes();
        $data['dishes'] = $order->getDishes($order_id);
        $data['order'] = $order->getOrder($order_id);
        if ($data['order'])
            $this->view('admin/order.detail', $data);
        else
            $this->view('admin/_404');
    }

    public function delete($order_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            (new Order)->deleteOrder($order_id);
        redirect('admin/orders');
    }
    public function history():void{
        $order = new Order;
        $p=$_GET['page']??1;
        $totalPages = $order->getPages();
        $ol = $order->getAllOrders($p);
        $data=[
            'currentPage'=>$p,
            'totalPages'=>$totalPages,
            'order_list'=>$ol,
        ];
        $this->view('admin/order.history', $data);
    }
}

