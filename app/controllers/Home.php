<?php

/**
 * Home Controller
 */

class Home
{
    use Controller;

    public function index(): void
    {

        $data['user'] = $_SESSION['user'] ?? null;

        #get dishes from database
        $d = new Dish();
        $data['dishes'] = $d->getDishes();

        #get menus from database
        $m = new Menu();
        $data['menus'] = $m->getMenus();

        #get menu items from database
        $mi = new MenuDishes();
        $data['menudishes'] = $mi->getMenuDishesByMenu();

        $this->view('home', $data);
    }
}
