<?php

namespace controllers\api;

use core\Controller;
use models\Order;

class Orders
{
    use Controller;

    public function index(): void
    {
        // implement later
        return;
    }

    public function update(): void
    {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $status = $post->status;

                $od = new \models\Order();

                $od->changeStatus($order_id, $status);
                $this->json([
                    'status' => 'success',
                    'message' => 'Order status changed'
                ]);
            } catch (\Exception $e) {
                $this->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function stream()
    {
        date_default_timezone_set("America/New_York");
        header("Cache-Control: no-store");
        header("Content-Type: text/event-stream");

        $data = [
            "order_id" => 1,
            "status" => "pending",
            "type" => "dine-in",
            "time_placed" => "2020-12-12 12:12:12",
            "scheduled_time" => "2020-12-12 12:12:12",
            "request" => "Remove the shells",
            "reg_customer_id" => 2,
        ];
    
        while (true) {
            // Every second, send a "ping" event.
    
            echo "event: ping\n";
            $curDate = date("Y-m-d H:i:s");
            echo 'data: {"time": "' . $curDate . '", "data": ' . json_encode($data) . '}';
            echo "\n\n";
    
            // Send a simple message every 5 seconds.
            static $counter = 0;
            $counter++;
    
            if ($counter == 5) {
                echo 'data: This is a message at time ' . $curDate . "\n\n";
                $counter = 0;
            }
    
            ob_end_flush();
            flush();
    
            // Break the loop if the client aborted the connection (closed the page)
            if (connection_aborted()) break;
    
            sleep(5);
        }
    }
    
}
