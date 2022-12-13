<?php

/**
 * Home Controller
 */

class Home
{
    use Controller;

    public function index(): void
    {
        $this->view("home");
    }
}
