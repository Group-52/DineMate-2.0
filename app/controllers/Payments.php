<?php


class Order_dishes
{
    use Controller;

    public function index($order_id)
    {
        $order_dish = new OrderDishModel();
        $orderDishes = $order_dish->getOrderDish($order_id);
        $this->view('order_dishes', ['order_dishes' => $orderDishes, 'controller' => 'orderDishes']);
   
    }
}
  
