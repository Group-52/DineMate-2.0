<?php

// Main Promotion class
namespace models;

// Main Promotion class

use core\Model;

class Promotion extends Model
{

    public string $order_column = "promo_id";

    public function __construct()
    {
        $this->table = "promotions";
        $this->columns = [
            "promo_id",
            "title",
            "type",
            "status",
            "description",
            "image_url",
            "deleted"
        ];
    }

    /**
     * @param $order_id
     * @return array
     * Get all valid promotions for a given order
     */
    public function getValidPromotions($order_id): array
    {
        $promotions = $this->getAllPromotions();
        $valid_promotions = [];
        foreach ($promotions as $promotion) {
            if ($promotion->type == 'spending_bonus') {
                $obj = new PromotionsSpendingBonus();
                $valid = $obj->checkValidPromotion($promotion->promo_id, $order_id);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            } else if ($promotion->type == 'discounts') {
                $obj = new PromotionsDiscounts();
                $valid = $obj->checkValidPromotion($promotion->promo_id, $order_id);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            } else if ($promotion->type == 'free_dish') {
                $obj = new PromotionsBuy1Get1Free();
                $valid = $obj->checkValidPromotion($promotion->promo_id, $order_id);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            }
        }
        return $valid_promotions;
    }

    /**
     * @param $order_id
     * @param $promo_id
     * @return float
     * Description: Get price reduction of order after applying promotion
     */
    public function reducedCost($order_id, $promo_id): float
    {
        $order = new Order();
        $promotion = $this->getPromotion($promo_id);
        $reduction = 0;
        if ($promotion->type == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $reduction = $obj->getReduction($promo_id, $order_id);
        } else if ($promotion->type == 'discounts') {
            $obj = new PromotionsDiscounts();
            $reduction = $obj->getReduction($promo_id, $order_id);
        } else if ($promotion->type == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $reduction = $obj->getReduction($promo_id, $order_id);
        }
        return $reduction;
    }

    /**
     * @param $user_id
     * @param $isGuest
     * @return array
     * Description: Get all valid promotions for the given cart
     */
    public function getValidPromotionsCart($user_id, $isGuest):array{
        $promotions = $this->getAllPromotions();
        $valid_promotions = [];
        foreach ($promotions as $promotion) {
            if ($promotion->type == 'spending_bonus') {
                $obj = new PromotionsSpendingBonus();
                $valid = $obj->checkValidPromotionCart($promotion->promo_id, $user_id, $isGuest);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            } else if ($promotion->type == 'discounts') {
                $obj = new PromotionsDiscounts();
                $valid = $obj->checkValidPromotionCart($promotion->promo_id, $user_id, $isGuest);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            } else if ($promotion->type == 'free_dish') {
                $obj = new PromotionsBuy1Get1Free();
                $valid = $obj->checkValidPromotionCart($promotion->promo_id, $user_id, $isGuest);
                if ($valid) {
                    $valid_promotions[] = $promotion;
                }
            }
        }
        return $valid_promotions;
    }

    /**
     * @param $user_id
     * @param $isGuest
     * @param $promo_id
     * @return float
     * Description: Get price reduction of cart after applying promotion
     */
    public function reducedCostCart($user_id, $isGuest, $promo_id): float
    {
        $promotion = $this->getPromotion($promo_id);
        $reduction = 0;
        if ($promotion->type == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $reduction = $obj->getReductionCart($promo_id, $user_id, $isGuest);
        } else if ($promotion->type == 'discounts') {
            $obj = new PromotionsDiscounts();
            $reduction = $obj->getReductionCart($promo_id, $user_id, $isGuest);
        } else if ($promotion->type == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $reduction = $obj->getReductionCart($promo_id, $user_id, $isGuest);
        }
        return $reduction;
    }
    public function getAllPromotions(): array
    {
        $a1 = $this->getDiscounts();
        $a2 = $this->getSpendingBonus();
        $a3 = $this->getFreeDish();
        return array_merge($a1, $a2, $a3);
    }

    public function getDiscounts(): array|bool
    {
        return $this->select(["promotions.*", "promo_discounts.*", "dishes.dish_name"])->
        join('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        join('dishes', 'promo_discounts.dish_id', 'dishes.dish_id')->
        where('promotions.type', 'discounts')->
        and('promotions.deleted', 0)->
        and('dishes.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }

    public function getSpendingBonus(): array|bool
    {
        return $this->select(["promotions.*", "promo_spending_bonus.*"])->
        join('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        where('promotions.type', 'spending_bonus')->
        and('promotions.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }

    public function getFreeDish(): array|bool
    {
        return $this->select(["promotions.*", "promo_buy1get1free.*", "dishes1.dish_name as dish1_name", "dishes2.dish_name as dish2_name"])->
        join('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id')->
        join('dishes as dishes1', 'promo_buy1get1free.dish1_id', 'dishes1.dish_id')->
        join('dishes as dishes2', 'promo_buy1get1free.dish2_id', 'dishes2.dish_id')->
        where('promotions.type', 'free_dish')->
        and('promotions.deleted', 0)->
        and('dishes1.deleted', 0)->
        and('dishes2.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }


    // Add a new entry to the promotions table and sub tables
    public function addPromotion($data): void
    {
        $this->insert([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => $data['status'],
            'image_url' => $data['image_url']
        ]);

        $data['promo_id'] = $this->select(['promo_id'])->where('title', $data['title'])->
        and('type', $data['type'])->fetch()->promo_id;

        // check for type of promotion and add to the respective table

        if ($data['type'] == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $obj->addpromotion($data['promo_id'], $data['spent_amount'], $data['bonus_amount']);
        } else if ($data['type'] == 'discounts') {
            $obj = new PromotionsDiscounts();
            $obj->addpromotion($data['promo_id'], $data['dish_id'], $data['discount']);
        } else if ($data['type'] == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $obj->addpromotion($data['promo_id'], $data['dish1_id'], $data['dish2_id']);
        }
    }

    // get one promotion by id
    public function getPromotion($id):Object|bool
    {
        return $this->select()->
        leftJoin('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        leftJoin('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        leftJoin('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id')->
        where('promotions.promo_id', $id)->and('promotions.deleted', 0)->
        fetch();
    }

    public function deletePromo($id): void
    {
        $this->update(["deleted" => 1])->where('promo_id', $id)->execute();
    }

    public function editPromo($data): void
    {
        $this->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => $data['status'],
        ])->where('promo_id', $data['promo_id'])->execute();
        if ($data['type'] == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $obj->editpromotion($data['promo_id'], $data['spent_amount'], $data['bonus_amount']);
        } else if ($data['type'] == 'discounts') {
            $obj = new PromotionsDiscounts();
            $obj->editpromotion($data['promo_id'], $data['dish_id'], $data['discount']);
        } else if ($data['type'] == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $obj->editpromotion($data['promo_id'], $data['dish1_id'], $data['dish2_id']);
        }
    }

    public function generateCardObject($promotion): object
    {
        $promoObj = new \stdClass();
        $promoObj->dish_id = $promotion->promo_id;
        $promoObj->dish_name = $promotion->title;
        $promoObj->description = $promotion->description;
        $promoObj->image_url = $promotion->image_url;
        if (isset($promotion->discount)) {
            $dish = (new Dish)->getDishById($promotion->dish_id);
            $promoObj->old_price = $dish->selling_price;
            $promoObj->selling_price = $dish->selling_price - $promotion->discount;
        } else if (isset($promotion->spent_amount)) {
            $promoObj->old_price = $promotion->spent_amount + $promotion->bonus_amount;
            $promoObj->selling_price = $promotion->spent_amount;
        } else {
            $dish1 = (new Dish)->getDishById($promotion->dish1_id);
            $dish2 = (new Dish)->getDishById($promotion->dish2_id);
            $promoObj->old_price = $dish1->selling_price + $dish2->selling_price;
            $promoObj->selling_price = $dish1->selling_price;
        }
        return $promoObj;
    }
}
