<?php

namespace models;
// Sub Promotions class for the spending bonus promotion

use core\Model;

class PromotionsSpendingBonus extends Model
{

    public string $order_column = "promo_id";
<<<<<<< HEAD
    protected string $table = 'promo_spending_bonus';
    protected array $allowedColumns = [
        'promo_id',
        'spent_amount',
        'bonus_amount',
    ];
=======

    public function __construct()
    {
        $this->table = "promo_spending_bonus";
        $this->columns = [
            "promo_id",
            "spent_amount",
            "bonus_amount",
        ];
    }
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

    /**
     * @param $promo_id
     * @param $order_id
     * @return bool
     * Check if the promotion is valid for the given order
     */
    public function checkValidPromotion($promo_id, $order_id): bool
    {
        $total = (new Order())->calculateSubTotal($order_id);
        $promotion = $this->getPromotion($promo_id);
        $spent = $promotion->spent_amount;
        if ($total >= $spent) {
            return true;
        }
        return false;
    }

    /**
     * @param $promo_id
     * @param $order_id
     * @return float
     * Get the reduction amount for the given promotion and order
     */
    public function getReduction($promo_id, $order_id): float
    {
        $total = (new Order())->calculateSubTotal($order_id);
        $promotion = $this->getPromotion($promo_id);
        $spent = $promotion->spent_amount;
        $bonus = $promotion->bonus_amount;
        if ($total >= $spent) {
            return $bonus;
        } else {
            return 0;
        }
    }

    /**
     * @param $promo_id
     * @param $user_id
     * @param $isGuest
     * @return float
     * Get the reduction amount for the given promotion and cart
     */
    public function getReductionCart($promo_id, $user_id, $isGuest): float
    {
        $total = (new Cart())->calculateSubTotal($user_id, $isGuest);
        $promotion = $this->getPromotion($promo_id);
        $spent = $promotion->spent_amount;
        $bonus = $promotion->bonus_amount;
        if ($total >= $spent) {
            return $bonus;
        } else {
            return 0;
        }
    }

    /**
     * @param $promo_id
     * @param $user_id
     * @param $isGuest
     * @return bool
     * Check if the promotion is valid for the given cart
     */
    public function checkValidPromotionCart($promo_id, $user_id, $isGuest): bool
    {
        $total = (new Cart())->calculateSubTotal($user_id, $isGuest);
        $promotion = $this->getPromotion($promo_id);
        $spent = $promotion->spent_amount;
        if ($total >= $spent) {
            return true;
        }
        return false;
    }

    // Get all entries in the table
    public function getPromos(): array
    {
        return $this->select('promotions.*')->
        join('promotions', 'promo_spending_bonus.promo_id', 'promotions.promo_id')->fetchAll();
    }

    // Add a new entry to the promo_spending_bonus table given the promo_id, spent_amount and bonus_amount
    public function addPromotion($pid, $spent, $bonus): void
    {
        $this->insert([
            'promo_id' => $pid,
            'spent_amount' => $spent,
            'bonus_amount' => $bonus
        ]);
    }

    // get one promotion by id
    public function getpromotion($id): bool|object
    {
        return $this->select()->where('promo_id', $id)->fetch();
    }

    public function editpromotion($id, $spent, $bonus): void
    {
        $this->update([
            'spent_amount' => $spent,
            'bonus_amount' => $bonus
        ])->where('promo_id', $id)->execute();
    }
}
