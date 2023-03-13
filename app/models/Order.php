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

    public function getOrderHistory($customer_id): array|false
    {
        return $this->select()->where("reg_customer_id", $customer_id)->fetchAll();
    }

    public function getOrder($order_id): object|false
    {
        return $this->select()->where("order_id", $order_id)->fetch();
    }

    public function editOrder($order)
    {
        $this->update($order)->where("order_id", $order['order_id'])->execute();
    }

    public function changeStatus($order_id, $status)
    {
        $this->update([
            'status' => $status
        ])->where('order_id', $order_id)->execute();
    }

    public function getDishes($order){
        $order_dishes = new OrderDishes();
        return $order_dishes->getOrderDishes($order);
    }
    public function complete($order_id){
        $t1 = new OrderDishes();
        $d = $t1->getOrderDishes($order_id);
        $t2 = new Ingredient();
        $t3 = new InventoryDetail();
        foreach($d as $dish){
            $ingredients = $t2->getDishIngredients($dish->dish_id);
            foreach($ingredients as $ingredient){
                // remove from stock
                // TODO add unit conversion
                $t3->reduce($ingredient->item_id, $ingredient->quantity, $ingredient->unit);
            }
        }

    }
}