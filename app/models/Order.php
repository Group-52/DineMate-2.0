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
            "total_cost",
            "collected"
        ];
    }

    // Get all orders with pagination
    public function getAllOrders($page = 1): array
    {
        $q = $this->select(['orders.*'])
            ->orderBy('time_placed', 'DESC');
        $skip = ($page - 1) * $this->nrows;
        if (!$page)
            return $q->fetchAll();
        else
            return $q->limit($this->nrows)->offset($skip)->fetchAll();
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

    // Get all orders placed between two dates
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

    // Get all orders that are placed or scheduled for today and also are pending or accepted
    public function getTodayChefOrders(): array|false
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

    //get all completed orders that are placed or scheduled for today
    public function getTodayCashierOrders($paid=0, $collected=0,$status="completed"): array|false
    {
        $a1 = $this->select(["orders.*", "reg_users.*"])
            ->join("reg_users", "orders.reg_customer_id", "reg_users.user_id")
            ->where("paid", $paid)
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected",$collected)
            ->and("status",$status)
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed", "ASC")
            ->fetchAll();
        $a2 = $this->select(["orders.*", "reg_users.*"])
            ->join("reg_users", "orders.reg_customer_id", "reg_users.user_id")
            ->where("paid", $paid)
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected",$collected)
            ->and("status",$status)
            ->orderBy("scheduled_time", "ASC")
            ->fetchAll();
        $a3 = $this->select(["orders.*", "guest_users.*"])
            ->join("guest_users", "orders.guest_id", "guest_users.guest_id")
            ->where("paid", $paid)
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected",$collected)
            ->and("status",$status)
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed", "ASC")
            ->fetchAll();
        $a4 = $this->select(["orders.*", "guest_users.*"])
            ->join("guest_users", "orders.guest_id", "guest_users.guest_id")
            ->where("paid", $paid)
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected",$collected)
            ->and("status",$status)
            ->orderBy("scheduled_time", "ASC")
            ->fetchAll();

        return array_merge($a2, $a1, $a3, $a4);
    }

    public function getOrder($order_id): object|false
    {
        $x = $this->select(["orders.reg_customer_id"])->where("order_id", $order_id)->fetch()->reg_customer_id;
        if ($x != null)
            return $this->select(["orders.*", "reg_users.*"])
                ->leftJoin("reg_users", "orders.reg_customer_id", "reg_users.user_id")
                ->where("order_id", $order_id)->fetch();
        else
            return $this->select(["orders.*", "guest_users.*"])
                ->leftJoin("guest_users", "orders.guest_id", "guest_users.guest_id")
                ->where("order_id", $order_id)->fetch();
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

    //calculate the total price of the order based on the dishes and their quantities only
    public function calculateTotal($order_id): float
    {
        $dishes = $this->getDishes($order_id);
        $total = 0;
        foreach ($dishes as $dish) {
            $total += $dish->selling_price * $dish->quantity;
        }
        return $total;
    }

    //update cost of the order
    public function updateCost($order_id): void
    {
        $this->update([
            'total_cost' => $this->calculateTotal($order_id)
        ])->where('order_id', $order_id)->execute();
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
                $t3->reduce($ingredient->item_id, $q1, $u1);
            }
        }
    }

    //Get all orders ahead of this one for today
    public function getOrdersAhead($order_id)
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

    public function validate(array $data): bool
    {
        $this->errors = [];

        if (empty($data['name']))
            $this->errors['name'] = 'Name is required';

        if (empty($this->errors))
            return true;

        return false;
    }


    public function addOrder($data): void
    {
        $this->insert($data);
    }

    //Get estimate of time for an order
    public function getEstimate($order_id): int
    {
        $ods = (new OrderDishes())->getOrderDishes($order_id);
        if (count($ods) == 0)
            return 0;
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

    public function deleteOrder($order_id)
    {
        $this->delete()->where("order_id", $order_id)->execute();
    }
}
