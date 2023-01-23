<?php

namespace controllers;

use components\MenuItem;
use core\Controller;
use models\Menu;
use models\MenuDishes;

class Menus
{
    use Controller;

    public function menu(int $menu_id): void
    {
        $menu = new Menu();
        $menuDetails = $menu->getMenu($menu_id);
        if ($menuDetails) {
            $data = [];
            $data['menu'] = $menuDetails;
            $menuDishes = (new MenuDishes())->getMenuDishes($menu_id);
            $data['menu_items'] = [];
            foreach ($menuDishes as $menuDish) {
                $data['menu_items'][] = new MenuItem($menuDish);
            }
            $this->view('menu', $data);
        } else {
            redirect("404");
        }
    }
}