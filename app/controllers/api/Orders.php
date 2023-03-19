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
    public function create(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $reg_customer_id = isset($post->reg_customer_id) ? $post->reg_customer_id : null;
                    $guest_id = isset($post->guest_id) ? $post->guest_id : null;
                    $scheduled_time = isset($post->scheduled_time) ? $post->scheduled_time : null;
                    $request = isset($post->request) ? $post->request : null;
                    $type = $post->type;
                    $table = isset($post->table) ? $post->table : null;
                    $dishlist = $post->dishlist;
                    $od = new Order();
                    // TODO debug the dishlist
                    $od->create($type, $dishlist, $reg_customer_id, $request, $guest_id, $table, $scheduled_time);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Order created'
                    ]);
                } catch (\Exception $e) {
                    $this->json([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]);
                }
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function changestatus(): void
    {
        if (isset($_SESSION['user'])) {
            try {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $status = $post->status;

                $od = new Order();

                $od->changeStatus($order_id, $status);
                if ($status === 'completed') {
                    $od->complete($order_id);
                }
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
    public function update(){
        if ($_SERVER ["REQUEST_METHOD"] == "POST") {

                try {
                    $post = json_decode(file_get_contents('php://input'));
                    $order_id = $post->order_id;
                    $scheduled_time = isset($post->scheduled_time) ? $post->scheduled_time : null;
                    $request = isset($post->request) ? $post->request : null;
                    $type = isset($post->type) ? $post->type : null;
                    $table = isset($post->table) ? $post->table : null;
                    $od = new Order();
                    $data = [
                        'order_id' => $order_id,
                        'type' => $type,
                        'scheduled_time' => $scheduled_time,
                        'request' => $request,
                        'table_id' => $table
                    ];
                    //remove null values
                    $data = array_filter($data, fn($v) => !is_null($v));
                    $od->editOrder($data);

                    $this->json([
                        'status' => 'success',
                        'message' => 'Order updated'
                    ]);
                } catch (\Exception $e) {
                    $this->json([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]);
                }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }
}
