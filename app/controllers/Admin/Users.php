<?php

namespace controllers\admin;

use core\Controller;
use models\Guest;
use models\RegUser;

/**
 * Class Guests
 */
class Users
{
    use Controller;

    public function index(): void
    {
        $guest = new Guest;
        $r = new RegUser();
        $results['reg'] = $r->getReg();
        $results['guest'] = $guest->getGuest();      
        $this->view('admin/user', $results);
    }
}