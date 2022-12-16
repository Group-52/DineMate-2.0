<?php

class Order extends Model
{
    public function __construct()
    {
        $this->table = "orders";
        $this->primary_key = "order_id";
        $this->columns = [
            "order_id",
            "reg_customer_id",
            "guest_id",
            "request",
            "time_placed",
            "type",
            "status",
            "scheduled_time",
            "table_id"
        ];
    }


    public function getOrders() {
        return $this->findAll();
    }

    public function getOrder($order_id) {
        return $this->findBy(["order_id" => $order_id]);
    }
}