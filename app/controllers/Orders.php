<?php

// dish class

class Orders
{
    use Controller;

    public function index()
    {
        $order = new Order;
        $results['orderlist'] = $order->getOrders();
        $this->view('order', $results);
    }


    public function edit($order_id)
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        $this->view('edit.order', $results);
    }
}

