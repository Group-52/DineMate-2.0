<?php

namespace models;

use core\Model;

class Unit extends Model
{
    public function __construct()
    {
        $this->table = "units";
        $this->columns = [
            "unit_id",
            "unit_name",
            "abbreviation",
            "type"
        ];
    }

    // add a unit
    public function addUnit($unit_name, $type, $abbreviation = null): void
    {
        $data = [
            "unit_name" => $unit_name,
            "abbreviation" => $abbreviation,
            "type" => $type
        ];
        $this->insert($data);
    }

    // convert unit

    // get all units
    public function getUnits(): array
    {
        return $this->select(["unit_id", "unit_name", "abbreviation", "type"])
            ->fetchAll();
    }

}