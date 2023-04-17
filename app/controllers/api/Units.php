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
}