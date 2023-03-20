<?php

namespace models;

use core\Model;

class UnitConversion extends Model
{
    public function __construct()
    {
        $this->table = "unit_conversion";
        $this->columns = [
            "u1",
            "u2",
            "conversion_factor"
        ];
    }

    // add a unit
    public function add($u1, $u2, $conversion_factor)
    {
        $data = [
            "u1" => $u1,
            "u2" => $u2,
            "conversion_factor" => $conversion_factor
        ];
        $this->insert($data);
    }

    // convert a unit to another
    //usage u1 to u2
    public function convert($u1, $u2, $quantity)
    {
        //If the units are the same, return the quantity
        if ($u1 == $u2) {
            return $quantity;
        }
        //If the units scale exist in the table, return the converted quantity
        $c0 = $this->select("conversion_factor")
            ->where("u1", $u1)
            ->and("u2", $u2)
            ->fetch();
        if ($c0) {
            return $quantity * $c0->conversion_factor;
        }

        $c1 = $this->select(["conversion_factor", "u2"])
            ->where("u1", $u1)
            ->fetch();
        $c2 = $this->select(["conversion_factor", "u2"])
            ->where("u1", $u2)
            ->fetch();

        if ($c1->u2 != $c2->u2) {
            return false;
        }

        $conversion_factor = $c1->conversion_factor / $c2->conversion_factor;
        return $quantity * $conversion_factor;

    }

}