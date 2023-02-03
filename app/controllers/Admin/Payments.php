<?php


namespace controllers\admin;

use core\Controller;
use models\Order;
use models\Payment;

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
        $results['order'] = $order->getOrder($order_id);

        $orderDish = new Payment();
        $results['dish'] = $orderDish->getOrderDish($order_id);
        $this->view('admin/payments.detail', $results);
    }
}
