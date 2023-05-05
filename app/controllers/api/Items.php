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

    public function delete($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item = new Item();
            try {
                $item->deleteItem($id);
                $this->json([
                    "status" => "success",
                    "message" => "Item deleted successfully."
                ]);
            } catch (\Exception $e) {
               $this->json([
                    "status" => "error",
                    "message" => "Item not found."
                ]);
            }
        } else {
            $this->json([
                "status" => "error",
                "message" => "Invalid Request"
            ]);
        }
    }

}