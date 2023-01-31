<?php

namespace controllers\api;

use core\Controller;
use models\Item;

class Items
{
    use Controller;

    public function index(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->json([
                "status" => "success",
                "items" => (new Item())->getItems()
            ]);
        } else
            $this->json([
                "status" => "error",
                "message" => "Invalid Request"
            ]);
    }
}