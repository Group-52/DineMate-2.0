<?php

namespace controllers\api;

use core\Controller;
use models\Order;
use WebSocket\Client;

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
                    $reg_customer_id = $post->reg_customer_id ?? null;
                    $guest_id = $post->guest_id ?? null;
                    $scheduled_time = $post->scheduled_time ?? null;
                    $request = $post->request ?? null;
                    $type = $post->type;
                    $table = $post->table ?? null;
                    $total = $post->netTotal ?? null;
                    $promo = $post->promotion ?? 1;
                    $svcharge = $post->serviceCharge ?? 0;
                    $dishlist = $post->dishlist;
                    $od = new Order();
                    $od->create($type, $dishlist, $reg_customer_id, $guest_id,$request, $table, $scheduled_time, $total,$promo,$svcharge);
                    $order_id = $od->lastInsertId();

                    $ws = new Client("ws://".SERVER_SOCKET_HOST.":8080");
                    $ws->text(json_encode([
                        "event_type" => "new_order",
                        'data'=>[
                            "order_id" => $order_id,
                            "status" => "pending",
                            "time_placed" => date("Y-m-d H:i:s"),
                            "request" => $request,
                            "user_id" => $reg_customer_id ?? $guest_id,
                            "user_type" => $reg_customer_id ? "registered" : "guest",
                            "type" => $type,
                            "scheduled_time" => $scheduled_time,
                            "table_id" => $table,
                            "order_dishes" => $dishlist
                        ]

                    ]));

                    if ($_SESSION['guest_id']){
                        unset($_SESSION['guest_id']);
                    }
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
                $scheduled_time = $post->scheduled_time ?? null;
                $request = $post->request ?? null;
                $type = $post->type ?? null;
                $table = $post->table ?? null;
                $promo = $post->promo ?? null;
                $paid = $post->paid ?? null;
                $total_cost = $post->total_cost ?? null;
                $collected = $post->collected ?? null;
                $service_charge = $post->service_charge ?? null;
                $od = new Order();
                $data = [
                    'order_id' => $order_id,
                    'type' => $type,
                    'scheduled_time' => $scheduled_time,
                    'request' => $request,
                    'table_id' => $table,
                    'promo' => $promo,
                    'paid' => $paid,
                    'total_cost' => $total_cost,
                    'collected'=>$collected,
                    'service_charge'=>$service_charge
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
