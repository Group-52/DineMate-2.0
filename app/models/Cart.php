<?php

namespace models;


use core\Model;

class Cart extends Model
{
    protected string $table = 'carts';
    protected string $primary_key = 'user_id';
    protected array $columns = [
        'dish_id',
        'user_id',
        'quantity'
    ];

    public function addCart($userID, $itemID)
    {
        $this->insert([
            'dish_id' => $itemID,
            'user_id' => $userID,
            'quantity' => 1
        ]);
    }

    // Get the cart items of a specific customer
    public function getCart($id): bool|array
    {
        $cartItems = $this->select()->where('user_id', $id)->fetchAll();
        $items = [];
        foreach ($cartItems as $item) {
            $items[$item->dish_id] = (new Dish)->getDishById($item->dish_id);
            $items[$item->dish_id]->quantity = $item->quantity;
        }
        return $items;
    }

    public function getCarts(): bool|array
    {
        return $this->select()->fetchAll();
    }


    public function getNoOfItems($id): int
    {
        $cart = $this->count("*")->where('user_id', $id)->fetch();
        return $cart->{'COUNT(*)'};
    }

}