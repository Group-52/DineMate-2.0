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
    public function getPromotion($id): bool|object
    {
        return $this->select()->where('promo_id', $id)->fetch();
    }

    public function checkValidPromotion($promo_id, $order_id): bool
    {
        $od = new Order();
        $dishes = $od->getDishes($order_id);
        //check if any of the dishes in the order are in the promotion
        foreach ($dishes as $dish) {
            $promotion = $this->getPromotion($promo_id);
            if ($dish->dish_id == $promotion->dish_id) {
                return true;
            }
        }
        return false;
    }

    public function getReduction($promo_id, $order_id): float
    {
        $od = new Order();
        $dishes = $od->getDishes($order_id);
        $promotion = $this->getPromotion($promo_id);
        $reduction = 0;
        foreach ($dishes as $dish) {
            if ($dish->dish_id == $promotion->dish_id) {
                $reduction = $dish->quantity * $promotion->discount;
            }
        }
        return $reduction;
    }

    public function editPromotion($id, $dish, $discount): void
    {
        $this->update([
            'dish_id' => $dish,
            'discount' => $discount,
        ])->where('promo_id', $id)->execute();
    }
}
