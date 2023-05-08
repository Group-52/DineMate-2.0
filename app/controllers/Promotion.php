<?php

namespace controllers;

use components\MenuCard;
use core\Controller;
use models\Dish;
use models\Guest;
use models\PromotionsBuy1Get1Free;
use models\PromotionsDiscounts;
use models\PromotionsSpendingBonus;
use models\RegUser;

class Promotion
{
    use Controller;

    public function index(): void
    {
        $data = [];
        $data['title'] = 'Promotion';

        $promotion = new \models\Promotion();
        $promotion_items = $promotion->getAllPromotions();
        foreach ($promotion_items as $promotion_item) {
            $data['promotion_items'][] = new MenuCard($promotion->generateCardObject($promotion_item), true);
        }
        $this->view('promotions', $data);
    }

    public function id($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $model = null;
            if (isRegistered()) {
                $model = new RegUser();
            } else if (isGuest()) {
                $model = new Guest();
            }
            if ($_POST["action"] == "apply" ) {
                $model->setPromoId(userId(), $id);
            } else {
                $model->setPromoId(userId(), 1);
            }
        }

        $data = [];
        $data['title'] = 'Promotion';

        $promotion = new \models\Promotion();
        $promotion_item = $promotion->getPromotion($id);

        $promo_id = 1;
        if (isRegistered()) {
            $promo_id = (new RegUser())->getPromoId(userId());
        } else if (isGuest()) {
            $promo_id = (new Guest())->getPromoId(userId());
        }
        if ($promo_id == $id) {
            $data['is_promo'] = true;
        } else {
            $data['is_promo'] = false;
        }

        $price = null;
        $promotion_type = null;
        $promotion_item_type = null;

        if ($promotion_item->type == "discounts") {
            $promotion_model = new PromotionsDiscounts();
            $promotion_discount = $promotion_model->getPromotion($id);
            $dish = (new Dish)->getDishById($promotion_discount->dish_id);
            $data["dish"] = $dish;
            $price = $dish->selling_price - $promotion_discount->discount;
            $promotion_type = "Discounts";
            $promotion_item_type = $promotion_discount;
        } else if ($promotion_item->type == "spending_bonus") {
            $promotion_model = new PromotionsSpendingBonus();
            $promotion_spending_bonus = $promotion_model->getPromotion($id);
            $price = $promotion_spending_bonus->spent_amount;
            $promotion_type = "Spending Bonus";
            $promotion_item_type = $promotion_spending_bonus;
        } else if ($promotion_item->type == "free_dish") {
            $promotion_model = new PromotionsBuy1Get1Free();
            $promotion_free_dish = $promotion_model->getPromotion($id);
            $promotion_type = "Buy 1 Get 1 Free";
            $dish1 = (new Dish)->getDishById($promotion_free_dish->dish1_id);
            $data["dish1"] = $dish1;
            $dish2 = (new Dish)->getDishById($promotion_free_dish->dish2_id);
            $data["dish2"] = $dish2;
            $price = $dish1->selling_price;
            $promotion_item_type = $promotion_free_dish;
        }
        $data["promotion"] = (object)array_merge((array)$promotion_item, (array)$promotion_item_type);
        $data["promotion"]->promo_type = $promotion_type;
        $data["promotion"]->price = $price;
        $this->view('promotion', $data);
    }
}