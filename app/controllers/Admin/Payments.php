<?php


namespace controllers\admin;

use core\Controller;
use models\Order;
use models\Payment;
use models\OrderDishes;

class Payments
{
    use Controller;

    public function index(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/payments', $results);
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['dishes'] = $order->getDishes($order_id);
        $data['order'] = $order->getOrder($order_id);
        $this->view('admin/payments.detail', $data);
    }

//     public function pay($order_id): void
//     {
//         $order = new OrderDishes;
//         $results['dishes'] = $order->getOrderDishes($order_id);
//         $this->view('admin/payments', $results);
//     }
}
