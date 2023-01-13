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

    // Check if entry exists in the cart table and return the quantity if exists
    public function checkCart($userid, $dish_id)
    {
        return $this->select(['quantity'])
            ->where('user_id', $userid)
            ->and('dish_id', $dish_id)
            ->fetch();
    }

    public function addCart($userid, $dish_id)
    {
        // if entry does not exist, insert new entry
        if (!$this->checkCart($userid, $dish_id)) {
            $this->insert([
                'user_id' => $userid,
                'dish_id' => $dish_id,
                'quantity' => 1
            ]);
        }
    }

    // Get the cart items of a specific customer
    public function getCart($id): bool|array
    {
        return $this->select('carts.*, dishes.dish_name, dishes.selling_price, dishes.image_url')
            ->join('dishes', 'carts.dish_id', 'dishes.dish_id')
            ->where('user_id', $id)
            ->fetchAll();
    }

    public function getCarts(): bool|array
    {
        return $this->select()->fetchAll();
    }

}
