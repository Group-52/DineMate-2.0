<?php

namespace controllers;

use core\Controller;
use models\Menu;

/**
 * Home Controller
 */
class Home
{
    use Controller;

    public function index(): void
    {
        $data['user'] = $_SESSION['user'] ?? null;

        /** TODO
         * Get number of items in cart
         */

        # Get Menus From Database
        $menus = (new Menu())->getMenus();
        foreach ($menus as $menu) {
            $data['menus'][$menu->menu_id] = new \components\Menu($menu->menu_id, $menu->menu_name, $menu->description, $menu->start_time, $menu->end_time, $menu->all_day);
        }
        $this->view('home', $data);
    }
}
