<?php
class loginK{
    use Controller;
    public function index()
    {
        echo "HI";
    }
    public function signup(){
        echo "You are at signup";
    }
    public function login(){
        $this->view('loginK');
    }
}