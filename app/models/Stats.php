<?php

namespace models;

// Stats class
use core\Model;

class Stats extends Model
{
    public string $order_column = "day";
    public function __construct()
    {
        $this->columns = [
            'day',
            'revenue',
            'foodCost',
            'dishesSold',
            'dineinTotal',
            'bulkTotal',
            'takeawayTotal',
            'dineinWaitTime',
            'takeawayWaitTime',
            'f_0', 'f_2', 'f_3', 'f_4', 'f_5', 'f_6', 'f_7', 'f_8',
            'f_9', 'f_10', 'f_11', 'f_12', 'f_13', 'f_14', 'f_15', 'f_16',
            'f_17', 'f_18', 'f_19', 'f_20', 'f_21', 'f_22', 'f_23', 'f_23',
        ];
        $this->table = 'stats';
    }

    //get all the data in the table in a date range
    public function getStats($start_date, $end_date): array
    {
        $rows = $this->select()->where('day', $start_date, ">=")
            ->and('day', $end_date, "<=")
            ->orderBy($this->order_column, 'ASC')->fetchAll();
        $n = count($rows);

        $cols = $this->columns;
        unset($cols[0]);

        $data_sum = array_fill_keys($cols, 0);
        $data_avg = array_fill_keys($cols, 0);
        foreach ($rows as $row) {
            foreach ($cols as $col) {
                $data_sum[$col] += $row->$col;
            }
        }
        if ($n) {
            foreach ($cols as $col) {
                $data_avg[$col] = $data_sum[$col] / $n;
            }
        }

        return [
            'sum' => $data_sum,
            'avg' => $data_avg,
        ];
    }

    //get no. of orders for each day of the week
    public function get_orders($sdate, $edate): array
    {
        $week = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
        $ods = (new Order())->getOrders($sdate, $edate);
        foreach ($ods as $od) {
            $day = date('l', strtotime($od->time_placed));
            $week[$day] += 1;
        }
        return $week;
    }

    public function getAll(): array
    {
        $this->select()->orderBy('day', 'DESC');
        return $this->fetchAll();
    }

//    public function addOrder($id)
//    {
//        $om = new Order();
//        $myorder = $om->getOrder($id);
//        $dishes = $om->getDishes($id);
//        $foodCost = 0;
//        $n = 0;
//        $revenue = $myorder->total_cost;
//
//        $o_type = $myorder->type;
//        //remove underscore from the type in case it's dine-in
//        $o_type = str_replace('_', '', $o_type);
//        $total_col = $o_type . 'Total';
//        $wait_col = $o_type . 'WaitTime';
//
//        //calculate the food cost and the number of dishes in the order
//        foreach ($dishes as $dish) {
//            $foodCost += $dish->net_price;
//            $n++;
//        }
//
//        //get the hour and date from the mysql timestamp
//        $hour = date('G', strtotime($myorder->time_placed));
//        $day = date('Y-m-d', strtotime($myorder->time_placed));
//        $hour_col = 'f_' . $hour;
//
//        $wait_time = 0;
//
//        //check if the order is scheduled or bulk else calculate the wait time
//        if (!$myorder->scheduled_time && $o_type !== 'bulk') {
//            //subtract mysql timestamp to get the wait time in minutes
//            $t1  = strtotime($myorder->time_placed);
//            $t2 = strtotime($myorder->time_completed);
//            $wait_time = ($t2 - $t1) / 60;
//        }
//
//        //check if the day already exists in the table
//        $row = $this->select()->where('day', $day)->fetch();
//        if ($row) {
//            //if it exists, update the row
//            $data = [
//                'revenue' => $row->revenue + $revenue,
//                'foodCost' => $row->foodCost + $foodCost,
//                'dishesSold' => $row->dishesSold + $n,
//                $total_col => $row->$total_col + 1,
//                $hour_col => $row->$hour_col + 1,
//            ];
//            if($o_type != 'bulk'){
//                $data[$wait_col] = $row->$wait_col + $wait_time;
//            }
//
//            $this->update($data)->where('day', $day)->execute();
//        } else {
//            //if it doesn't exist, create a new row
//            $data1 = [
//                'day' => $day,
//                'revenue' => $revenue,
//                'foodCost' => $foodCost,
//                'dishesSold' => $n,
//                $total_col => 1,
//                $hour_col => 1,
//            ];
//            if($o_type != 'bulk'){
//                $data1[$wait_col] = $wait_time;
//            }
//            $this->insert($data1);
//        }
//
//    }


}

