<?php

namespace models;

use core\Model;

class OrderDishes extends Model
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

    // get all dishes in an order
    public function getOrderDishes($order_id): array
    {

        return $this->select(["order_dishes.*", "dishes.dish_name", "dishes.selling_price", "dishes.prep_time","dishes.image_url"])
            ->join("dishes", "order_dishes.dish_id", "dishes.dish_id")
            ->where("order_dishes.order_id", $order_id)
            ->fetchAll();
    }

    // delete a dish from an order
    public function deleteOrderDish($order_id, $dish_id): void
    {
        $this->delete()->where("order_id", $order_id)->where("dish_id", $dish_id)->execute();
    }

    // add a dish to an order
    public function addOrderDish($order_id, $dish_id, $quantity): void
    {
        $this->insert([
            "order_id" => $order_id,
            "dish_id" => $dish_id,
            "quantity" => $quantity
        ]);
    }

    // update quantity of a dish in an order
    public function updateOrderDish($order_id, $dish_id, $quantity): void
    {
        $this->update([
            "quantity" => $quantity
        ])
        ->where("order_id", $order_id)
        ->and("dish_id", $dish_id)->execute();
    }
<<<<<<< HEAD
=======

    public function getAll($sd, $ed){
        $sd = date("Y-m-d", strtotime($sd));
        $ed = date("Y-m-d", strtotime($ed));
        return $this->select(["order_dishes.*", "dishes.dish_name", "dishes.selling_price", "dishes.prep_time","dishes.net_price","orders.time_placed"])
            ->join("dishes", "order_dishes.dish_id", "dishes.dish_id")
            ->join("orders", "order_dishes.order_id", "orders.order_id")
            ->where("time_placed", $sd, ">=")
            ->and("time_placed", $ed, "<=")
            ->fetchAll();
    }
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
}