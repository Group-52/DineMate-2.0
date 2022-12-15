

<?php

class Carts
{
    use Controller;

    public function index()
    {
        return;
    }
 
    public function viewCart($id): void
    {
        $cart = new Cart;
        $results['cartlist'] = $cart->getCart($id);
        $this->view('cart', $results);
    }
}