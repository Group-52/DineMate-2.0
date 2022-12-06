<?php

/**
 * Home Controller
 */

class Home
{
    use Controller;

    public function index(): void
    {
        $data['username'] = empty($_SESSION['user_id']) ? 'User':$_SESSION['fname'];
        $this->view("home", $data);
    }
}
