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
        $data['reg'] = $r->getReg();
        $data['guest'] = $guest->getGuest();
        $data['controller'] = 'users';
        $this->view('admin/user', $data);
    }
}