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
            "time_completed",
            "type",
            "status",
            "scheduled_time",
            "table_id",
            "paid",
            "promo",
            "total_cost"
        ];
    }

    // Create a new order
    public function create($type, $dishlist, $reg_customer_id = null, $guest_id = null, $request = null, $table_id = null, $scheduled_time = null): void
    {
        $data = [];
        $time_placed = date("Y-m-d H:i:s");

        // Checking type of customer
        if ($reg_customer_id) {
            $data['reg_customer_id'] = $reg_customer_id;
        } else {
            $data['guest_id'] = $guest_id;
        }

        $data += [
            'type' => $type,
            'time_placed' => $time_placed,
            'scheduled_time' => $scheduled_time,
            'request' => $request,
            'status' => 'pending',
            'table_id' => $table_id
        ];

        $this->insert($data);
        $order_id = $this->lastInsertId();
        // add dishes to the order
        $m = new OrderDishes();
        foreach ($dishlist as $dish) {
            $m->addOrderDish($order_id, $dish->dish_id, $dish->quantity);
        }
    }

    public function getOrders($sd = null, $ed = null): array|false
    {
        //Converts date to timestamp format for database compatibility
        if ($sd && $ed) {
            $sd_timestamp = date('Y-m-d H:i:s', strtotime($sd));
            $ed_timestamp = date('Y-m-d H:i:s', strtotime($ed));
            return $this->select()->where('time_placed', $sd_timestamp, ">=")
                ->and('time_placed', $ed_timestamp, "<=")
                ->orderBy("time_placed", "ASC")->fetchAll();
        } else
            return $this->select()->fetchAll();
    }

    // Get all orders that are pending or accepted
    public function getActiveOrders(): array|false
    {
        //Get orders placed today and not scheduled
        $q1 = $this->select()
            ->where("status", "rejected", "!=")
            ->and("status", "completed", "!=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed", "ASC")
            ->fetchAll();
        //Get orders scheduled for today
        $q2 = $this->select()
            ->where("status", "rejected", "!=")
            ->and("status", "completed", "!=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->orderBy("scheduled_time", "ASC")
            ->fetchAll();


        //merge the two arrays based on time_placed and scheduled_time
        $q = array_merge($q2, $q1);
        usort($q, function ($a, $b) {
            //get times in only hour and minute format
            $aptime = date('H:i:A', strtotime($a->time_placed));
            $bptime = date('H:i:A', strtotime($b->time_placed));
            $astime = $a->scheduled_time ? date('H:i:A', strtotime($a->scheduled_time)) : null;
            $bstime = $b->scheduled_time ? date('H:i:A', strtotime($b->scheduled_time)) : null;
            if ($astime == null && $bstime == null) {
                return $aptime <=> $bptime;
            } else if ($astime && $bstime) {
                return $astime <=> $bstime;
            } else if ($bstime == null) {
                return $astime <=> $bptime;
            } else {
                return $aptime <=> $bstime;
            }
        });
        return $q;

    }

    public function getOrder($order_id): object|false
    {
        return $this->select()->where("order_id", $order_id)->fetch();
    }

    public function editOrder($order): void
    {
        $this->update($order)->where("order_id", $order['order_id'])->execute();
    }

    // Change order from pending/accepted/rejected/completed
    public function changeStatus($order_id, $status): void
    {
        $this->update([
            'status' => $status
        ])->where('order_id', $order_id)->execute();
    }

    // Get the dishes in a given order
    public function getDishes($order): array
    {
        $order_dishes = new OrderDishes();
        return $order_dishes->getOrderDishes($order);
    }

    // Complete the order by removing the ingredient amount from the inventory
    public function complete($order_id): void
    {
        $d = (new OrderDishes())->getOrderDishes($order_id);
        $t2 = new Ingredient();
        $t3 = new InventoryDetail();

        foreach ($d as $dish) {
            $ingredients = $t2->getDishIngredients($dish->dish_id);
            foreach ($ingredients as $ingredient) {
                $u1 = $ingredient->unit;
                $q1 = $ingredient->quantity * $dish->quantity;
                $t3->reduce($ingredient->item_id, $q1, $u1);
            }
        }
    }

    //Get all orders ahead of this one for today
    public function getOrdersAhead($order_id): int
    {
        $o = $this->getOrder($order_id);
        $q = $this->select()->where("time_placed", $o->time_placed, "<")
            ->and("status", "completed", "!=")
            ->and("status", "rejected", "!=")
            ->orderBy("time_placed", "ASC")->fetchAll();

        // if they are scheduled for a different day, they are not ahead
        foreach ($q as $key => $order) {
            if ($order->scheduled_time && date("Y-m-d", strtotime($order->scheduled_time)) != date("Y-m-d", strtotime($o->time_placed)))
                unset($q[$key]);
        }
        return count($q);
    }

    //Get estimate of time for an order
    public function getEstimate($order_id): int
    {
        $ods = (new OrderDishes())->getOrderDishes($order_id);
        $t = [];
        //Adjust prep time of dishes for quantity
        foreach ($ods as $d) {
            //multiples of 5 of dish quantity
            $m = $d->quantity / 5;
            // 20% of prep time
            $p = $d->prep_time * 0.2;
            $t[] = ceil($d->prep_time + $p * $m);
        }
        //get average time
        $x = array_sum($t) / count($t);
        //get max time
        $m = max($t);
        //weigh between average and max time
        $x = ($x + $m) / 2;

        //add 5 minutes for each order ahead of this one (account for no.of staff)
        $staff = (new GeneralDetails())->getDetails()->kitchen_staff;
        $staffcoeff = 5 - $staff;
        if ($staffcoeff < 0)
            $staffcoeff = 0;
        $x += $this->getOrdersAhead($order_id) * $staffcoeff;

        return ceil($x);
    }

    public function deleteOrder($order_id): void
    {
        $this->delete()->where("order_id", $order_id)->execute();
    }
}
