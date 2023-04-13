<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Order;

class OrderHist
{
    use Controller;
    
    public function index(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/order.manager', $results);
    }

    public function edit($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $order = new Order;
            $order->editOrder($_POST);
            redirect('admin/OrderHist');
        }
        $this->view('admin/order.edit', $results);
    }

    public function id($customer_id): void
    {
        $order = new Order;
        $data['dishes'] = $order->getDishes($customer_id);
        $data['order'] = $order->getOrder($customer_id);
        $data['history'] = $order->getOrderHistory($customer_id);
        $this->view('admin/order.history', $data);
    }
}