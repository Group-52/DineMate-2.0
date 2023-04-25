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

    public function addMenu(): void
    {

        if(isset($_POST['save'])){
            $menu_name = $_POST['menu_name'];
            $description = $_POST['description']?? null;
            $start_time = $_POST['start_time']?? null;
            $end_time = $_POST['end_time']?? null;
            $image_url = $_POST['image_url'];
            $all_day = $_POST['all_day']?? null;

            //if all_day is set, set start_time and end_time to null
            if($all_day){
                $start_time = null;
                $end_time = null;
            }

            $m = new Menu;
            $data = [
                'menu_name' => $menu_name,
                'description' => $description,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'all_day' => $all_day,
                'image_url' => $image_url
            ];
            array_filter($data);
            $m ->addMenu($data);

            redirect('admin/menus');

        }
        $this->view('admin/menus');
    }

    public function delete($menu_id): void
    {
        $dish = new Menu;
        $dish->deleteMenu($menu_id);
        redirect('admin/menus');
    }

    public function edit($menu_id): void
    {
        $menu = new Menu;
        $results['m'] = $menu->getMenu($menu_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $menu = new Menu;
            $menu->editMenu($_POST);
            redirect('admin/menus');
        }
        $this->view('admin/menu.edit', $results);
    }

    public function addDish(int $menu_id): void
    {

        if(isset($_POST['save'])){
            $dish_id = $_POST['selected_dish'];

            $md = new MenuDishes;
            $md ->addMenuDish([
                'menu_id' => $menu_id,
                'dish_id'=> $dish_id,
            ]);

            redirect('admin/menus/id/'.$menu_id);

        }
        $this->view('admin/menus/id/'.$menu_id);
    }

    public function deleteDish($menu_id,$dish_id): void
    {
        $md = new MenuDishes;
        $md->deleteDishes($menu_id,$dish_id);
        redirect('admin/menus/id/'.$menu_id);

    }
}
