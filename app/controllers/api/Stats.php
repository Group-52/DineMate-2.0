<?php

namespace controllers\api;

use core\Controller;

class Stats
{
    use Controller;

    public function index(): void
    {
        $this->json([
            'success' => true,
            'data' => 'Hello World'
        ]);
    }

    public function get_orders(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //get the start and end date from json
            $post = json_decode(file_get_contents('php://input'), true);
            $start_date = $post['start'];
            $end_date = $post['end'];

            $stats = (new \models\Stats())->get_orders($start_date, $end_date);
            $this->json([
                'success' => true,
                'data' => $stats
            ]);
        }
    }

    public function get_stats(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //get the start and end date from json
            $post = json_decode(file_get_contents('php://input'), true);
            $start_date = $post['start'];
            $end_date = $post['end'];

            $stats = (new \models\Stats())->getStats($start_date, $end_date);
            $this->json([
                'success' => true,
                'data' => $stats
            ]);
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $stats = (new \models\Stats())->getAll("today","last year");
            $this->json([
                'success' => true,
                'data' => $stats
            ]);
        }
    }

    public function get_menu_stats(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //get the start and end date from json
            $post = json_decode(file_get_contents('php://input'), true);
            $start_date = $post['start'];
            $end_date = $post['end'];

            $stats = (new \models\MenuStats())->getMenuStats($start_date, $end_date);
            $this->json([
                'success' => true,
                'data' => $stats
            ]);
        }
    }

    public function download(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
            $table = $_GET['table'];
            $start = $_GET['start'] ?? null;
            $end = $_GET['end'] ?? null;
            $stats = [];
            $invalidtable = false;
            //Check get params
            if ($table == 'menu_statistics') {
                $stats = (new \models\MenuStats())->getAll($start, $end);
            } else if ($table == 'stats') {
                $stats = (new \models\Stats())->getAll($start, $end);
            } else if ($table == 'orders') {
                $stats = (new \models\Order())->getOrders($start, $end);
            } else if ($table == 'order_dishes') {
                $stats = (new \models\OrderDishes())->getAll($start, $end);
            } else if ($table == 'purchases') {
                $stats = (new \models\Purchase())->getAll($start, $end);
            } else if ($table == 'feedback') {
                $stats = (new \models\Feedback())->getAll($start, $end);
            } else {
                $invalidtable = true;
            }

            if ($invalidtable) {
                $this->json([
                    'success' => false,
                    'error' => 'Invalid table'
                ]);
            } else if ($stats) {
                $this->json([
                    'success' => true,
                    'data' => $stats
                ]);
            } else {
                $this->json([
                    'success' => false,
                    'error' => 'No data found in that range'
                ]);
            }


        } else {
            $this->json([
                'success' => false,
                'error' => 'Invalid request'
            ]);
        }
    }

}