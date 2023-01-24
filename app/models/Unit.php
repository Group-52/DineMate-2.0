<?php

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
    public function addUnit($unit_name, $type, $abbreviation=null)
    {
        $data = [
            "unit_name" => $unit_name,
            "abbreviation" => $abbreviation,
            "type" => $type
        ];
        return $this->insert($data);
    }

    // convert unit

    // get all units
    public function getUnits()
    {
        return $this->select(["unit_id", "unit_name", "abbreviation", "type"])
            ->fetchAll();
    }

}