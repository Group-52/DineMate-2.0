

<?php

class Carts
{
    use Controller;

    public function index()
    {
        return;
    }
 
    public function viewcart($id)
    {
        $cart = new Cart;
        $results['cartlist'] = $cart->getCart($id);
        $this->view('cart', $results);
        return;
    }
}