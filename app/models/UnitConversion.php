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

    /**
     * Convert a unit to another
     * @param string $u1 The unit to convert from
     * @param string $u2 The unit to convert to
     * @param float $quantity The quantity to convert
     * @return float The converted quantity
     */
    public function convert($u1, $u2, $quantity)
    {
        //If the units are the same, return the quantity
        if ($u1 == $u2) {
            return $quantity;
        }
        //If the units scale exist in the table, return the converted quantity eg. x to g/ml
        $c0 = $this->select("conversion_factor")
            ->where("u1", $u1)
            ->and("u2", $u2)
            ->fetch();
        if ($c0) {
            return $quantity * $c0->conversion_factor;
        }
        //If the units scale exist in the table, return the converted quantity eg. g/ml to x
        $c0 = $this->select("conversion_factor")
            ->where("u1", $u2)
            ->and("u2", $u1)
            ->fetch();
        if ($c0) {
            return $quantity / $c0->conversion_factor;
        }
        //Or convert both to g/ml and return the converted quantity

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

//    public function testdisplay()
//    {
//        $this->query="SELECT u1.unit_name AS unit1_name, u1 AS u1_id, u2.unit_name AS unit2_name, u2 as u2_id, unit_conversion.conversion_factor FROM unit_conversion JOIN units u1 ON unit_conversion.u1 = u1.unit_id JOIN units u2 ON unit_conversion.u2 = u2.unit_id";
//        return $this->fetchAll();
//    }

}