<?php

namespace controllers\admin;
use core\Controller;
use models\Order;
use models\Dish;

class Orders
{
    use Controller;

    public function index(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('order', $results);
    }

    public function detail(): void
    {
        $order = new Order;
         $results['order_list'] = $order->getOrders();
        $this->view('order.detail');
    }


    public function edit($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $order = new Order;
            $order->editOrder($_POST);
            redirect('orders');
        }
        $this->view('order.edit', $results);
    }

    public function payment($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);


        $dish = new Dish();
        $dishes = $dish->getDishById(34);
        print_r($results);die();
        $this->view('payment', $results);

    }
}

