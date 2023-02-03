<?php

namespace models;

use core\Model;

class Order extends Model
{
    public function __construct()
    {
        $this->table = "orders";
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


    public function getOrders(): array|false
    {
        return $this->select()->fetchAll();
    }

    public function getOrder($order_id): object|false
    {
        return $this->select()->where("order_id", $order_id)->fetch();
    }

    public function editOrder($order)
    {
        $this->update($order)->where("order_id", $order['order_id'])->execute();
    }
}