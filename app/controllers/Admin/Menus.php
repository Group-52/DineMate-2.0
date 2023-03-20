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
        if(isset($_POST['submit'])){
            $menu_name = $_POST['menu_name'];
			$description = $_POST['description'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$image_url = $_POST['image_url'];

			$vendor = new Menu;
			$vendor ->add([
                'menu_name' => $menu_name,
				'description'=> $description,
				'start_time'=> $start_time,
				'end_time'=> $end_time,
                'image_url'=> $image_url
			]);

            redirect('admin/menus');

        }
        $this->view('admin/menus');
    }

    public function delete($menu_id): void
    {
        $dish = new Menu;
        $results['m'] = $dish->deleteMenu($menu_id);
        redirect('admin/menus'); 
            
    }

}

