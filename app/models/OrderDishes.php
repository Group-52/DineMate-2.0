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
    public function getOrderDish($order_id): array
    {

        return $this->select(["order_dishes.*", "dishes.dish_name", "dishes.selling_price", "dishes.prep_time","dishes.image_url"])
            ->join("dishes", "order_dishes.dish_id", "dishes.dish_id")
            ->where("order_dishes.order_id", $order_id)
            ->fetchAll();
    }

    // delete a dish from an order
    public function deleteOrderDish($order_id, $dish_id)
    {
        $this->delete()->where("order_id", $order_id)->where("dish_id", $dish_id)->execute();
    }

    // add a dish to an order
    public function addOrderDish($order_id, $dish_id, $quantity)
    {
        $this->insert([
            "order_id" => $order_id,
            "dish_id" => $dish_id,
            "quantity" => $quantity
        ]);

    }
}