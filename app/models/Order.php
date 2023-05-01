<?php

namespace models;

use core\Model;

class Order extends Model
{
    protected int $nrows = 30;

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
            "collected",
            "service_charge"
        ];
    }

    /**
     * Get all orders with pagination.
     * @param int $page
     * @return array
     */
    public function getAllOrders(int $page = 1): array
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

    /**
     * @param string|null $sd
     * @param string|null $ed
     * @return array|false
     * Returns an array of orders between the two given dates
     */
    public function getOrders($sd = null, $ed = null): array|false
    {
        //Converts date to timestamp format for database compatibility
        if ($sd && $ed) {
            $sd_timestamp = date('Y-m-d H:i:s', strtotime($sd));
            $ed_timestamp = date('Y-m-d H:i:s', strtotime($ed));
            return $this->select()->where('time_placed', $sd_timestamp, ">=")
                ->and('time_placed', $ed_timestamp, "<=")
                ->orderBy("time_placed")->fetchAll();
        } else
            return $this->select()->fetchAll();
    }

    /**
     * @return array|false
     * Description: Returns an array of orders that are placed or scheduled for today and also are pending or accepted
     */
    public function getActiveOrders(): array|false
    {
        //Get orders placed today and not scheduled
        $q1 = $this->select()
            ->where("status", "rejected", "!=")
            ->and("status", "completed", "!=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed")
            ->fetchAll();
        //Get orders scheduled for today
        $q2 = $this->select()
            ->where("status", "rejected", "!=")
            ->and("status", "completed", "!=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->orderBy("scheduled_time")
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

    /**
     * @param int $paid
     * @param int $collected
     * @param string $status
     * @return array|false
     * Returns an array of orders that are placed or scheduled for today with given status
     */
    public function getTodayCashierOrders(int $paid = 0, int $collected = 0, string $status = "completed"): array|false
    {
        $a1 = $this->select(["orders.*", "reg_users.*"])
            ->join("reg_users", "orders.reg_customer_id", "reg_users.user_id")
            ->where("paid", $paid)
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected", $collected)
            ->and("status", $status)
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed")
            ->fetchAll();
        $a2 = $this->select(["orders.*", "reg_users.*"])
            ->join("reg_users", "orders.reg_customer_id", "reg_users.user_id")
            ->where("paid", $paid)
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected", $collected)
            ->and("status", $status)
            ->orderBy("scheduled_time")
            ->fetchAll();
        $a3 = $this->select(["orders.*", "guest_users.*"])
            ->join("guest_users", "orders.guest_id", "guest_users.guest_id")
            ->where("paid", $paid)
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("time_placed", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected", $collected)
            ->and("status", $status)
            ->checkNull("AND", "scheduled_time")
            ->orderBy("time_placed")
            ->fetchAll();
        $a4 = $this->select(["orders.*", "guest_users.*"])
            ->join("guest_users", "orders.guest_id", "guest_users.guest_id")
            ->where("paid", $paid)
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('today')), ">=")
            ->and("scheduled_time", date('Y-m-d H:i:s', strtotime('tomorrow')), "<")
            ->and("collected", $collected)
            ->and("status", $status)
            ->orderBy("scheduled_time")
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

    public function editOrder($order): void
    {
        $this->update($order)->where("order_id", $order['order_id'])->execute();
    }

    /**
     * @param $order_id
     * @param $status
     * Description: Changes the status of an order(pending,accepted, rejected, completed)
     */
    public function changeStatus($order_id, $status): void
    {
        $this->update([
            'status' => $status
        ])->where('order_id', $order_id)->execute();
        if ($status == 'completed') {
            //reduce stock
            $this->complete($order_id);
        }
    }

    /**
     * @param $order
     * @return array
     * Description: Gets the dishes in a given order
     */
    public function getDishes($order): array
    {
        $order_dishes = new OrderDishes();
        return $order_dishes->getOrderDishes($order);
    }


    /**
     * @param $order_id
     * @return float
     * Description: Calculates the total cost of the order based on the dishes and their quantities without promotion or service charge
     */
    public function calculateSubTotal($order_id): float
    {
        $dishes = $this->getDishes($order_id);
        $total = 0;
        foreach ($dishes as $dish) {
            $total += $dish->selling_price * $dish->quantity;
        }
        return $total;
    }

    /**
     * @param $order_id
     * @return float
     * Description: Calculates the total cost of the order based on the dishes and their quantities with promotion and service charge included
     */
    public function calculateFullTotal($order_id): float
    {
        $order = $this->getOrder($order_id);
        $total = $this->calculateSubTotal($order_id);

        //if order type is dine-in add 0.05 service charge
        if ($order->type == "dine-in") {
            $total = $total + ($total * 0.05);
        }

        //Check if the order has a promotion
        $pcode = $this->select(["promo"])->where("order_id", $order_id)->fetch()->promo;
        if ($pcode != 1) {
            //Get the promotion
            $pcost = (new Promotion())->reducedCost($order_id, $pcode);
            $total = $total - $pcost;
        }

        return $total;
    }

    /**
     * @param $order_id
     * @param $cost
     * Description: Updates the total cost of the order, can override cost manually
     * @return void
     */
    public function updateCost($order_id, $cost = null): void
    {
        $cost = $cost ?? $this->calculateFullTotal($order_id);
        $this->update([
            'total_cost' => $cost
        ])->where('order_id', $order_id)->execute();
    }

    /**
     * @param $order_id
     * Description: Completes the order by removing the ingredient amount from the inventory and adding details to stats
     * @return void
     */
    public function complete($order_id): void
    {
        //add to stats
        (new Stats())->addOrder($order_id);
        (new MenuStats())->addOrder($order_id);

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

    /**
     * @param $order_id
     * @return int
     * Description: Returns the number of orders ahead of the given order
     */
    public function getOrdersAhead($order_id): int
    {
        $o = $this->getOrder($order_id);
        $q = $this->select()->where("time_placed", $o->time_placed, "<")
            ->and("status", "completed", "!=")
            ->and("status", "rejected", "!=")
            ->orderBy("time_placed")->fetchAll();

        // if they are scheduled for a different day, they are not ahead
        foreach ($q as $key => $order) {
            if ($order->scheduled_time && date("Y-m-d", strtotime($order->scheduled_time)) != date("Y-m-d", strtotime($o->time_placed)))
                unset($q[$key]);
        }
        return count($q);
    }

    /**
     * @param $order_id
     * @param $promo
     * @return void
     * Description: Adds a promotion to an order
     */
    public function addPromo($order_id, $promo): void
    {
        $this->update([
            'promo' => $promo
        ])->where('order_id', $order_id)->execute();
    }

    /**
     * @param $order_id
     * @return void
     * Description: Removes a promotion from an order
     */
    public function removePromo($order_id): void
    {
        $this->update([
            'promo' => 1
        ])->where('order_id', $order_id)->execute();
    }

    /**
     * @param $order_id
     * @return int
     * Description: Estimates in minutes the time it will take to prepare a given order
     */
    public function getEstimate($order_id): int
    {
        $ods = (new OrderDishes())->getOrderDishes($order_id);
        if (count($ods) == 0)
            return 0;
        $t = [];
        //Adjust prep time of dishes for quantity
        foreach ($ods as $d) {
            //multiples of 5 of dish quantity
            $m = floor($d->quantity / 5);
            // 20% of prep time
            $p = $d->prep_time * 0.2;
            $t[] = ceil($d->prep_time + $p * $m);
        }
        //get max time
        $x = max($t);

        //add x minutes for each order ahead of this one (account for no.of staff)
        $staff = (new GeneralDetails())->getDetails()->kitchen_staff;
        $staffcoeff = 5 - $staff;
        if ($staffcoeff < 0)
            $staffcoeff = 0;
        $x += $this->getOrdersAhead($order_id) * $staffcoeff;

        return floor($x);
    }

    /**
     * @param $order_id
     * @return int
     * Description: Returns the time remaining in minutes for the order to be completed, if order is not completed adds 5 minutes
     * Assumes chef accepts order within 2 minutes of placement
     */
    public function getTimeRemaining($order_id): int
    {
        $o = $this->getOrder($order_id);
        if ($o->status == "completed")
            return 0;
        $time_placed = date("Y-m-d H:i:s", strtotime($o->time_placed));
        $estimate = $this->getEstimate($order_id);
        $remaining = ceil((strtotime($time_placed) + $estimate * 60 - time())/60);

        if ($remaining <= 0)
            return 5;
        else
            return $remaining;
    }


    public function deleteOrder($order_id): void
    {
        $this->delete()->where("order_id", $order_id)->execute();
    }
}
