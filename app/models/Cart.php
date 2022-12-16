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

    public function addCart($userid,$itemid)
    {
        $this->insert([
            'item_id' => $itemid,
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
            $l[$c->item_id] = $d->getDishById($c->item_id);
        }
        return $l;
    }

    public function getCarts(): bool|array
    {
        return $this->select()->fetchAll();
    }


}