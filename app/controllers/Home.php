<?php

namespace controllers;

use components\MenuCard;
use core\Controller;
use models\Menu;
use models\Promotion;
use models\Dish;

/**
 * Home Controller
 */
class Home
{
    use Controller;

    public function index(): void
    {
        if (!isset($_SESSION['user']->emp_id)) {
            $data['user'] = $_SESSION['user'] ?? null;

            $promotions = array_slice((new Promotion)->getAllPromotions(), 0, 4);
            foreach ($promotions as $promotion) {
                $promoObj = new \stdClass();
                $promoObj->dish_id = $promotion->promo_id;
                $promoObj->dish_name = $promotion->title;
                $promoObj->description = $promotion->description;
                $promoObj->image_url = $promotion->image_url;
                if (isset($promotion->discount)) {
                    // Discount
                    $dish = (new Dish)->getDishById($promotion->dish_id);
                    $promoObj->old_price = $dish->selling_price;
                    $promoObj->selling_price = $dish->selling_price - $promotion->discount;
                } else if (isset($promotion->spent_amount)) {
                    // Spend $X get $Y
                    $promoObj->old_price = $promotion->spent_amount + $promotion->bonus_amount;
                    $promoObj->selling_price = $promotion->spent_amount;
                } else {
                    // Buy One, Get One Free
                    $dish1 = (new Dish)->getDishById($promotion->dish1_id);
                    $dish2 = (new Dish)->getDishById($promotion->dish2_id);
                    $promoObj->old_price = $dish1->selling_price + $dish2->selling_price;
                    $promoObj->selling_price = $dish1->selling_price;
                }
                $data['promotions'][] = new MenuCard($promoObj, true);
            }

            $menus = (new Menu())->getMenus();
            foreach ($menus as $menu) {
                $data['menus'][$menu->menu_id] = new \components\Menu($menu, 4);
            }

            $this->view('home', $data);
        } else {
            redirect("admin");
        }
    }
}
