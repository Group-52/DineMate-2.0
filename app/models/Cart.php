<?php
class Cart extends Model
{
    public string $order_column = "user_id";
    protected string $table = 'carts';
    protected string $primary_key = 'user_id';
    protected array $allowedColumns = [
        'item_id',
        'user_id',
        'quantity'
    ];

    public function addCart($data)
    {
        $this->insert($data);
    }

    // Get the cart items of a specific customer
    public function getCart($id): bool|array
    {
        $d = new Dish();
        $cart = $this->find($id);
        $l = array();
        foreach($cart as $c) {
            $l[$c->item_id] = $d->getDishById($c->item_id);
        }
        return $l;
    }

    public function getCarts(): bool|array
    {
        $carts = $this->findAll();
        return $carts;
    }


}