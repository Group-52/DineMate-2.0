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

        // if(isset($_GET[]))
    }

    public function detail()
    {
       $order = new Order;
     //  $results['order'] = $order->getOrder($order_id);
        $this->view('order.detail');
    }


    public function edit($order_id)
    {
       $order = new Order;
       $results['order'] = $order->getOrder($order_id);
        $this->view('edit.order',$results);

        // if (isset($_POST['submit'])) {
        //     $order_id = $_POST['order_id'];
        //     $request = $_POST['request'];
        //     $time_placed = $_POST['time_placed'];
        //     $type = $_POST['type'];
        //     $status = $_POST['status'];
        //     $scheduled_time = $_POST['scheduled_time'];
        //     $table_id = $_FILES["table_id"];

        //     $order = new Order;
        //     $order -> editOrder([
        //         'order_id'=> $order_id,
        //         'request'=> $request,
        //         'time_placed'=> $time_placed,
        //         'type'=> $type,
        //         'status'=> $status,
        //         'scheduled_time'=> $scheduled_time,
        //         'table_id'=> $table_id
        //     ]);

        //     redirect('order');
    }
}

