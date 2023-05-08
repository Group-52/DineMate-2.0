<?php

namespace controllers\api;

use controllers\Auth;
use core\Controller;
use models\Dish;
use models\PromotionsBuy1Get1Free;
use models\PromotionsDiscounts;
use models\PromotionsSpendingBonus;
use models\RegUser;

class Promotions
{
    use Controller;

    public function getValidPromotions(): void
    {
        $p = new \models\Promotion();
        $post = json_decode(file_get_contents('php://input'));
        $utype = $post->utype == 'guest';
        $userid = $post->uid;
        if ($utype == 'guest') {
            $plist =  $p->getValidPromotionsCart($userid, true);
        } else {
            $plist= $p->getValidPromotionsCart($userid, false);
        }

        $this->json([
            'status' => 'success',
            'promotions' => $plist
        ]);
    }

    public function getReduction():void{
        $p = new \models\Promotion();
        $post = json_decode(file_get_contents('php://input'));
        $utype = $post->utype=='guest';
        $userid = $post->uid;
        $promo = $post->promo;
        $reduction = $p->reducedCostCart($userid, $utype, $promo);
        $this->json([
            'status' => 'success',
            'reduction' => $reduction
        ]);
    }

    public function details(): void {
        $promo_id = 1;
        if (isRegistered()) {
            $promo_id = (new RegUser())->getPromoId(userId());
        }
        else if (isGuest()) {
            $promo_id = (new \models\Guest())->getPromoId(userId());
        }

        $promotion = new \models\Promotion();
        $promotion_item = $promotion->getPromotion($promo_id);

        $promotion_type = null;
        $old_price = null;
        $new_price = null;
        $promotion_item_type = null;

        if ($promotion_item->type == "discounts") {
            $promotion_model = new PromotionsDiscounts();
            $promotion_discount = $promotion_model->getPromotion($promo_id);
            $dish = (new Dish)->getDishById($promotion_discount->dish_id);
            $old_price = $dish->selling_price;
            $new_price = $dish->selling_price - $promotion_discount->discount;
            $promotion_type = "Discounts";
            $promotion_item_type = $promotion_discount;
        } else if ($promotion_item->type == "spending_bonus") {
            $promotion_model = new PromotionsSpendingBonus();
            $promotion_spending_bonus = $promotion_model->getPromotion($promo_id);
            $old_price = $promotion_spending_bonus->spent_amount + $promotion_spending_bonus->bonus_amount;
            $new_price = $promotion_spending_bonus->spent_amount;
            $promotion_type = "Spending Bonus";
            $promotion_item_type = $promotion_spending_bonus;
        } else if ($promotion_item->type == "free_dish") {
            $promotion_model = new PromotionsBuy1Get1Free();
            $promotion_free_dish = $promotion_model->getPromotion($promo_id);
            $promotion_type = "Buy 1 Get 1 Free";
            $dish1 = (new Dish)->getDishById($promotion_free_dish->dish1_id);
            $dish2 = (new Dish)->getDishById($promotion_free_dish->dish2_id);
            $old_price = $dish1->selling_price + $dish2->selling_price;
            $new_price = $dish1->selling_price;
            $promotion_item_type = $promotion_free_dish;
        }
        $promotion = (object)array_merge((array)$promotion_item, (array)$promotion_item_type);

        $this->json([
            'status' => 'success',
            'promotion' => $promotion,
            'promotion_type' => $promotion_type,
            'oldPrice' => $old_price,
            'newPrice' => $new_price,
            'discount' => $old_price - $new_price
        ]);
    }

    public function spendingBonusDetails(): void {
        $promo_id = 1;
        if (isRegistered()) {
            $promo_id = (new RegUser())->getPromoId(userId());
        }
        else if (isGuest()) {
            $promo_id = (new \models\Guest())->getPromoId(userId());
        }
        $promo = (new \models\Promotion())->getPromotion($promo_id);
        if ($promo->type == "spending_bonus") {
            $promo_spending_bonus = (new \models\PromotionsSpendingBonus())->getPromotion($promo_id);
            $sub_total = (new \models\Cart())->calculateSubTotal(userId(), isGuest());
            $this->json([
                'status' => 'success',
                'promotion' => $promo,
                'sub_total' => $sub_total,
                'spent_amt' => $promo_spending_bonus->spent_amount,
                'bonus_amt' => $promo_spending_bonus->bonus_amount
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Not a spending bonus promotion.'
            ]);
        }
    }
}