<?php

namespace controllers;

use core\Controller;
use models\Menu;

/**
 * Dish Class
 */
class Menus
{
    use Controller;

    public function index()
    {
        $m = new Menu();
        $results['menulist'] = $m->getMenus();
        $this->view('menus', $results);
    }
}

