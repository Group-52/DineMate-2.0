<?php

namespace models;

// Sub Promotions class for the buy 1, get 1 free promotion

use core\Model;

class PromotionsBuy1Get1Free extends Model
{

    public string $order_column = "promo_id";
    public function __construct()
    {
        $this->table = "promo_buy1get1free";
        $this->columns = [
            "promo_id",
            "dish1_id",
            "dish2_id",
        ];
    }

    // Get all entries in the table 
    public function getPromos(): bool|array
    {
        return $this->select('promotions.*')->
        leftJoin('promotions', 'promo_buy1get1free.promo_id', 'promotions.promo_id')->fetchAll();
    }

    // Add a new entry to the promos_get1buy1free table given the promo_id, dish1_id and dish2_id
    public function addPromotion($pid, $d1, $d2)
    {
        $this->insert([
            'promo_id' => $pid,
            'dish1_id' => $d1,
            'dish2_id' => $d2,
        ]);
    }

    // get one promotion by id
    public function getPromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        return $l;
    }
}
