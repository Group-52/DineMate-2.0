<?php

namespace controllers\admin;

use core\Controller;
use models\Menu;
use models\MenuDishes;
use models\Dish;

/**
 * Statistics Class
 */
class Stats
{
    use Controller;

    public function index(): void
    {
        $data =[
            'controller' => 'stats',
        ];
        $this->view('admin/stats', $data);
    }


}

