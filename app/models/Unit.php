<?php

namespace models;

use core\Model;

class Unit extends Model
{
    public function __construct()
    {
        $this->table = "units";
        $this->columns = [
            "name"
        ];
    }
}