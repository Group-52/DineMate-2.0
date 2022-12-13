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

        #get 5 dishes from database
        $d = new Dish();
        $data['dishes'] = $d->getDishes();
        $m = new Menu();
        $data['menus'] = $m->getMenus();
        $this->view('home', $data);
    }
}
