<?php


class Payments
{
    use Controller;

    public function index($order_id)
    {

        $order = new Order;
        $results['order'] = $order->getOrder($order_id);


        $orderDish = new  Payment();
        $results['dish'] = $orderDish->getOrderDish($order_id);
        $this->view('payment', $results);
   
    }
}
  
