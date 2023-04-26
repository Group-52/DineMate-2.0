<?php

namespace models;

use core\Model;

class Payment extends Model
{
    public function __construct()
    {
        $this->table = "order_dishes";
        $this->columns = [
            "order_id",
            "dish_id",
            "quantity"
        ];
    }

    //view order dishes
    public function getOrderDish($order_id): array
    {

        return $this->select(["order_dishes.*", "dishes.dish_name", "dishes.selling_price"])
            ->join("dishes", "order_dishes.dish_id", "dishes.dish_id")
            ->where("order_dishes.order_id", $order_id)
            ->fetchAll();

        // $orderDishtList = [];
        // foreach ($orderDishes as $orderDish) {
        //     $orderDishtList[$orderDish->dish_id][] = $orderDish;
        // }
        // return  $orderDishtList;
    }
    
}