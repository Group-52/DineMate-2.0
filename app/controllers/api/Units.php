<?php

namespace controllers\api;

use core\Controller;
use models\Unit;

class Units
{
    use Controller;

    public function index(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->json([
                "status" => "success",
                "units" => (new Unit())->getUnits()
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid Request"
            ]);
    }

    public function match():void{
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $post = json_decode(file_get_contents('php://input'), true);
            $unit_id = $post['unit_id'];
            $item_id = $post['item_id'];
            $this->json([
                "status" => "success",
                "match" => (new Unit())->unitMatch($unit_id,$item_id)
            ]);
        }
    }
}