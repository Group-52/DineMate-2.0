

<?php

class Carts
{
    use Controller;

    public function index()
    {
        return;
    }
 
    public function viewCart(): void
    {
        if (isset($_SESSION['user'])) 
            $id = $_SESSION['user']->user_id;
            $cart = new Cart;
            $results['cartlist'] = $cart->getCart($id);
            $this->view('cart', $results);
    }
}