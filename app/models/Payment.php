<?php

class OrderDishModel extends Model
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

    public function getOrderDish($order_id) {
        return $this->select("order_dishes.*, dishes.name as dish_name, dishes.id as dish_id")
        ->join("dishes", "order_dishes.dish_id", "=", "dishes.id")
        ->where("order_dishes.order_id", $order_id)
        ->fetchAll();
        }
    }