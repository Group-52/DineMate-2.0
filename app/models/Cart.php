<?php

class Cart extends Model
{
    protected string $table = 'carts';
    protected string $primary_key = 'user_id';
    protected array $columns = [
        'dish_id',
        'user_id',
        'quantity'
    ];

    public function addCart($userid,$itemid)
    {
        $this->insert([
            'dish_id' => $itemid,
            'user_id' => $userid,
            'quantity' => 1
        ]);
    }

    // Get the cart items of a specific customer
    public function getCart($id): bool|array
    {
        $d = new Dish();
        $cart = $this->select()->where('user_id', $id)->fetchAll();
        $l = array();
        foreach ($cart as $c) {
            $l[$c->dish_id] = $d->getDishById($c->dish_id);
        }
        return $l;
    }

    public function getCarts(): bool|array
    {
        return $this->select()->fetchAll();
    }


}