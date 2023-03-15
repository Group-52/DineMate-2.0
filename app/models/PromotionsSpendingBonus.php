<?php

namespace models;
// Sub Promotions class for the spending bonus promotion

use core\Model;

class PromotionsSpendingBonus extends Model
{

    public string $order_column = "promo_id";
    public function __construct()
    {
        $this->table = "promo_spending_bonus";
        $this->columns = [
            "promo_id",
            "spent_amount",
            "bonus_amount",
        ];
    }

    // Get all entries in the table
    public function getPromos()
    {
        return $this->select('promotions.*')->
        join('promotions', 'promo_spending_bonus.promo_id', 'promotions.promo_id')->fetchAll();
    }

    // Add a new entry to the promo_spending_bonus table given the promo_id, spent_amount and bonus_amount
    public function addPromotion($pid, $spent, $bonus)
    {
        $this->insert([
            'promo_id' => $pid,
            'spent_amount' => $spent,
            'bonus_amount' => $bonus
        ]);
    }

    // get one promotion by id
    public function getpromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        return $l;
    }
}
