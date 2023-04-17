<?php

namespace models;
// Sub Promotions class for the discounts promotion

use core\Model;

class PromotionsDiscounts extends Model
{
    public string $order_column = "promo_id";
    public function __construct()
    {
        $this->table = "promo_discounts";
        $this->columns = [
            "promo_id",
            "dish_id",
            "discount",
        ];
    }

    // Get all entries in the table 
    public function getPromos(): bool|array
    {
        return $this->select('promotions.*')->
        join('promotions', 'promo_discounts.promo_id', 'promotions.promo_id')->fetchAll();
    }

    // Add a new entry to the promo_discounts table given the promo_id, dish_id and discount
    public function addPromotion($pid, $d, $disc)
    {
        $this->insert([
            'promo_id' => $pid,
            'dish_id' => $d,
            'discount' => $disc,
        ]);
    }

    // get one promotion by id
    public function getPromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        return $l;
    }

    public function editPromotion($id, $dish, $discount): void
    {
        $this->update([
            'dish_id' => $dish,
            'discount' => $discount,
        ])->where('promo_id', $id)->execute();
    }
}
