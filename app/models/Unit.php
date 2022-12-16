<?php

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