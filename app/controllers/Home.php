<?php

/**
 * Home Controller
 */

class Home
{
    use Controller;

    public function index()
    {

        $data['username'] = empty($_SESSION['user_id']) ? 'User' : $_SESSION['fname'];

        #get dishes from database
        $d = new Dish();
        $data['dishes'] = $d->getDishes();

        #get menus from database
        $m = new Menu();
        $data['menus'] = $m->getMenus();

        #get menu items from database
        $mi = new Menuitems();
        $data['menuitems'] = $mi->getMenuItemsByMenu();

        $this->view('home', $data);
    }
}
