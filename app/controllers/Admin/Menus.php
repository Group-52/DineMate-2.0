<?php

namespace controllers\admin;

use core\Controller;
use models\Menu;
use models\MenuDishes;
use models\Dish;

/**
 * Dish Class
 */
class Menus
{
    use Controller;

    public function index(): void
    {
        $m = new Menu();
        $data['menulist'] = $m->getMenus();
        $data['controller'] = 'menus';

        $this->view('admin/menus', $data);
    }

    public function id(int $menu_id): void
    {
        $d = new Dish();
        $m = new Menu();
        $m2 = new MenuDishes();
        $data['menu'] = $m->getMenu($menu_id);
        $data['menu_items'] = $m2->getMenuDishes($menu_id);
        $data['controller'] = 'menus';
        $data['dishes'] = $d->getDishes();

        $this->view('admin/menu.update', $data);
    }
    public function add(): void
    {
        $data['controller'] = 'menus';
        // TODO- Process adding menu (POST REQEUST)
    }

    public function delete($menu_id): void
    {
        $dish = new Menu;
        $results['m'] = $dish->deleteMenu($menu_id);
        redirect('admin/menus'); 
            
    }

}

