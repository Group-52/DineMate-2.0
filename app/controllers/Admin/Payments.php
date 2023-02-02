<?php


namespace controllers\admin;

use core\Controller;
use models\Order;
use models\Payment;

class Payments
{
    use Controller;

    public function index($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);

        $orderDish = new Payment();
        $results['dish'] = $orderDish->getOrderDish($order_id);
        $this->view('admin/payment', $results);
    }
}
  
