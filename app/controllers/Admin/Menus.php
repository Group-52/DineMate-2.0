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
        if (!$data['menu']){
            redirect('admin/_404');
            return;
        }
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
            $file = $_FILES['image_url'];

            // Check if image field is empty
            if ($file['size'] != 0) {
                $target_dir = '../public/assets/images/menus/';

                if (isImage($file) && isValidSize($file, 5000000) && isImageType($file)) {

                    // 	// Set path to store the uploaded image
                    $target_file = getFileName($menu_name, $file);

                    if (!move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_dir . $target_file)) {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            $m = new Menu;
            $data = [
                'menu_name' => $menu_name,
                'description' => $description,
                'image_url' => $target_file ?? null,
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
        if (!$results['m']){
            redirect('admin/_404');
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $menu = new Menu;
            array_filter($_POST);
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
