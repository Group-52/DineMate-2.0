<?php

namespace models;

use core\Model;

class Order extends Model
{
    protected int $nrows = 15;

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

    // Create a new order
    public function create($type, $dishlist, $reg_customer_id = null, $request = null, $guest_id = null, $table_id = null, $scheduled_time = null)
    {
        $data = [];
        $time_placed = date("Y-m-d H:i:s");

        // Checking type of customer
        if ($reg_customer_id) {
            $data['reg_customer_id'] = $reg_customer_id;
            $key = "reg_customer_id";
            $value = $reg_customer_id;
        } else {
            $data['guest_id'] = $guest_id;
            $key = "guest_id";
            $value = $guest_id;
        }

        $data = [
            'type' => $type,
            'time_placed' => $time_placed,
            'scheduled_time' => $scheduled_time,
            'request' => $request,
            'status' => 'pending',
            'table_id' => $table_id
        ];

        $this->insert($data);
        // get the auto incremented order id
        $oid = $this->select('order_id')
            ->where($key, $value)->and("time_placed", $time_placed)
            ->orderBy("order_id", "DESC")->limit(1);

        // add dishes to the order
        $m = new OrderDishes();
        foreach ($dishlist as $dish) {
            $m->addOrderDish($oid, $dish['dish_id'], $dish['quantity']);
        }
    }

    public function getOrders(): array|false
    {
        return $this->select()->fetchAll();
    }

    // Get all orders that are pending or accepted with pagination
    public function getValidOrders($page = 1): array|false
    {
        $q= $this->select()
            ->where("status", "rejected", "!=")
            ->and("status", "completed", "!=")
            ->orderBy("time_placed", "ASC");
        $skip = ($page - 1) * $this->nrows;
        if (!$page)
            return $q->fetchAll();
        else
            return $q->limit($this->nrows)->offset($skip)->fetchAll();
    }

    public function getOrder($order_id): object|false
    {
        return $this->select()->where("order_id", $order_id)->fetch();
    }

    public function editOrder($order)
    {
        $this->update($order)->where("order_id", $order['order_id'])->execute();
    }

    // Change order from pending/accepted/rejected/completed
    public function changeStatus($order_id, $status)
    {
        $this->update([
            'status' => $status
        ])->where('order_id', $order_id)->execute();
    }

    // Get the dishes in a given order
    public function getDishes($order)
    {
        $order_dishes = new OrderDishes();
        return $order_dishes->getOrderDishes($order);
    }

    // Complete the order by removing the ingredient amount from the inventory
    public function complete($order_id)
    {
        $d = (new OrderDishes())->getOrderDishes($order_id);
        $t2 = new Ingredient();
        $t3 = new InventoryDetail();

        foreach ($d as $dish) {
            $ingredients = $t2->getDishIngredients($dish->dish_id);
            foreach ($ingredients as $ingredient) {
                $u1 = $ingredient->unit;
                $q1 = $ingredient->quantity * $dish->quantity;
                $t3->reduce($ingredient->item_id,$q1, $u1);
            }
        }
    }
}
