<?php

namespace controllers;

use components\MenuCard;
use core\Controller;
use models\GeneralDetails;
use models\MenuDishes;

class Menu
{
    use Controller;

    public function index(): void
    {
        redirect("home");
    }

    public function id(int $menu_id): void
    {
        $menu = new \models\Menu();
        $menuDetails = $menu->getMenu($menu_id);
        $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
        if ($menuDetails) {
            $data = [];
            $data["menu"] = $menuDetails;
            $menuDishes = (new MenuDishes())->getMenuDishes($menu_id, 100, 0, true);
            $data["menu_items"] = [];
            foreach ($menuDishes as $menuDish) {
                $data["menu_items"][] = new MenuCard($menuDish);
            }
            $data["title"] = $menuDetails->menu_name;
            $this->view("menu", $data);
        } else {
            redirect("404");
        }
    }
}