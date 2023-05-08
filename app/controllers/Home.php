<?php

namespace controllers;

use components\MenuCard;
use core\Controller;
use models\GeneralDetails;
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
            $data = [];
            $data['user'] = $_SESSION['user'] ?? null;
            $data["footer_details"] = (new GeneralDetails())->getFooterDetails();

            $promotion = new Promotion();
            $promotion_items = array_slice($promotion->getAllPromotions(true), 0, 4);
            foreach ($promotion_items as $promotion_item) {
                $data['promotion_items'][] = new MenuCard($promotion->generateCardObject($promotion_item), true);
            }

            $menus = (new Menu())->getMenus();
            foreach ($menus as $menu) {
                $data['menus'][$menu->menu_id] = new \components\Menu($menu, 4);
            }

            $data["title"] = "Home";
            $this->view('home', $data);
        } else {
            redirect("admin");
        }
    }
}
