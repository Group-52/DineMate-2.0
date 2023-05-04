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
            if ($dish->dish_id == $promotion->dish1_id) {
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

        //check how many of dish 1 is in the order
        $dish1_count = 0;
        foreach ($dishes as $dish) {
            if ($dish->dish_id == $promotion->dish1_id) {
                $dish1_count = $dish->quantity;
            }
        }

        //if dish1 is same as dish2
        if ($promotion->dish1_id == $promotion->dish2_id) {
            $dish1_count = $dish1_count / 2;
        }

        $dish2price = (new Dish())->getDishById($promotion->dish2_id)->selling_price;
        return $dish1_count * $dish2price;
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
        $od = new Cart();
        $dishes = $od->getCartItems($user_id, $isGuest);
        //check if any of the dishes in the order are in the promotion
        foreach ($dishes as $dish) {
            $promotion = $this->getPromotion($promo_id);
            if ($dish->dish_id == $promotion->dish1_id) {
                return true;
            }
        }
        return false;
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
        $od = new Cart();
        $dishes = $od->getCartItems($user_id, $isGuest);
        $promotion = $this->getPromotion($promo_id);

        //check how many of dish 1 is in the order
        $dish1_count = 0;
        foreach ($dishes as $dish) {
            if ($dish->dish_id == $promotion->dish1_id) {
                $dish1_count = $dish->quantity;
            }
        }

        //if dish1 is same as dish2
        if ($promotion->dish1_id == $promotion->dish2_id) {
            $dish1_count = $dish1_count / 2;
        }

        $dish2price = (new Dish())->getDishById($promotion->dish2_id)->selling_price;
        return $dish1_count * $dish2price;
    }
    public function editPromotion($id, $d1, $d2): void
    {
        $this->update([
            'dish1_id' => $d1,
            'dish2_id' => $d2,
        ])->where('promo_id', $id)->execute();
    }
}
