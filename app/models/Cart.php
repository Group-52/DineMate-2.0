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

    public function addToCart($userID, $itemID, $qty = 1)
    {
        $this->insert([
            'dish_id' => $itemID,
            'user_id' => $userID,
            'quantity' => $qty
        ]);
    }

    public function deleteFromCart($userID, $itemID)
    {
        $this->delete()->where('user_id', $userID)->and('dish_id', $itemID)->execute();
    }

    // Get the cart items of a specific customer
    public function getCartItems(): bool|array
    {
        $cartItems = $this->select()->where('user_id', $_SESSION["user"]->user_id)->fetchAll();
        $items = [];
        foreach ($cartItems as $item) {
            $dish = (new Dish)->getDishById($item->dish_id);
            $dish->quantity = $item->quantity;
            $items[] = $dish;
        }
        return $items;
    }

    public function getNoOfItems($id): int
    {
        $cart = $this->count("*")->where('user_id', $id)->fetch();
        return $cart->{'COUNT(*)'};
    }

    public function getQty($user_id, $dish_id): int
    {
        $qty = $this->select()->where('user_id', $user_id)->and('dish_id', $dish_id)->fetch();
        if (!$qty) {
            return 0;
        }
        return $qty->quantity;
    }

    public function editCartItemQty($user_id, $dish_id, $qty): void
    {
        $this->update(['quantity' => $qty])->where('user_id', $user_id)->and('dish_id', $dish_id)->execute();
    }
}