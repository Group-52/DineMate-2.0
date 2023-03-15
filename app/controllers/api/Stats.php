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
            $stats = (new \models\Stats())->getStats('2019-01-01', date('Y-m-d'));
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
            $stats = [];
            //Check get params
            if ($table == 'menu_statistics') {
                $stats = (new \models\Stats())->getAll();
            } else if ($table == 'stats') {
                $stats = (new \models\Stats())->getAll();
            } else if ($table == 'orders') {
                $stats = (new \models\Order())->getOrders();
            } else if ($table == 'order_dishes') {
                $stats = (new \models\OrderDishes())->getAll();
            } else if ($table == 'dishes') {
                $stats = (new \models\Dish())->getDishes();
            } else if ($table == 'purchases') {
                $stats = (new \models\Purchase())->getAllPurchases();
            } else if ($table == 'feedback') {
                $stats = (new \models\FeedbackModel())->getFeedback();
            } else if ($table == 'customers') {
                $stats = (new \models\RegUser())->getReg();
            }

            if ($stats) {
                $this->json([
                    'success' => true,
                    'data' => $stats
                ]);
            } else {
                $this->json([
                    'success' => false,
                    'data' => 'Invalid table'
                ]);
            }
        } else {
            $this->json([
                'success' => false,
                'data' => 'Invalid request'
            ]);
        }
    }

}