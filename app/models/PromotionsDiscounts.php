<?php

namespace models;
// Sub Promotions class for the discounts promotion

use core\Model;

class PromotionsDiscounts extends Model
{

    public string $order_column = "promo_id";
<<<<<<< HEAD
    protected string $table = 'promo_discounts';
    protected array $allowedColumns = [
        'promo_id',
        'dish_id',
        'discount',
    ];
=======

    public function __construct()
    {
        $this->table = "promo_discounts";
        $this->columns = [
            "promo_id",
            "dish_id",
            "discount",
        ];
    }
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

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

    /**
     * @param $promo_id
     * @param $order_id
     * @return bool
     * Check if the promotion is valid for the given order
     */
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
    /**
     * @param $promo_id
     * @param $order_id
     * @return float
     * Get the reduction amount for the given promotion and order
     */
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

    /**
     * @param $promo_id
     * @param $user_id
     * @param $isGuest
     * @return float
     * Get the reduction amount for the given promotion and cart
     */
    public function getReductionCart($promo_id, $user_id, $isGuest): float
    {
        $dishes = (new Cart())->getCartItems($user_id, $isGuest);
        $promotion = $this->getPromotion($promo_id);
        $reduction = 0;
        foreach ($dishes as $dish) {
            if ($dish->dish_id == $promotion->dish_id) {
                $reduction = $dish->quantity * $promotion->discount;
            }
        }
        return $reduction;

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
        $dishes = (new Cart())->getCartItems($user_id, $isGuest);
        //check if any of the dishes in the order are in the promotion
        foreach ($dishes as $dish) {
            $promotion = $this->getPromotion($promo_id);
            if ($dish->dish_id == $promotion->dish_id) {
                return true;
            }
        }
        return false;
    }

    public function editPromotion($id, $dish, $discount): void
    {
        $this->update([
            'dish_id' => $dish,
            'discount' => $discount,
        ])->where('promo_id', $id)->execute();
    }
}
