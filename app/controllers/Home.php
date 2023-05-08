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

            $promotion = new Promotion();
            $promotion_items = array_slice($promotion->getAllPromotions(true), 0, 4);
            foreach ($promotion_items as $promotion_item) {
                $data['promotion_items'][] = new MenuCard($promotion->generateCardObject($promotion_item), true);
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
