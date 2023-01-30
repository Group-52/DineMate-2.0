<?php

namespace controllers\admin;

use core\Controller;
use models\Menu;

/**
 * Dish Class
 */
class Menus
{
    use Controller;

    public function index(): void
    {
        $m = new Menu();
        $results['menulist'] = $m->getMenus();
        $this->view('admin/menus', $results);
    }

}

