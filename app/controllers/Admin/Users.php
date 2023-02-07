<?php

namespace controllers\admin;

use core\Controller;
use models\Guest;
// use models\Dish;

/**
 * Class Guests
 */
class Users
{
    use Controller;

    public function index(): void
    {
        $guest = new Guest;
        // $d = new Dish();
        // $results['dishes'] = $d->getDishes();
        $results['guest'] = $guest->getGuest();      
        $this->view('admin/user', $results);
    }
}