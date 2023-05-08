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

    //given a unit and an item checks whether unit type is compatible with item
    public function unitMatch($unit_id, $item_id): bool
    {
        if (!$unit_id || !$item_id) {
            return false;
        }
        $itemUnit = (new Item())->getItemById($item_id)->unit;
        $ut1 = $this->select(["type"])
            ->where('unit_id', $unit_id)
            ->fetch();
        $ut2 = $this->select(["type"])
            ->where('unit_id', $itemUnit)
            ->fetch();

        if (!$ut1 || !$ut2) {
            return false;
        }
        if ($ut1 == $ut2) {
            return true;
        } else {
            return false;
        }
    }

}