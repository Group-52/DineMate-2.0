<?php

namespace models;


use core\Model;

class Cart extends Model
{
    protected string $table = 'carts';
    protected array $columns = [
        'dish_id',
        'reg_customer_id',
        'guest_id',
        'quantity'
    ];

    public function addToCart($userID, $itemID, $qty = 1, $isGuest = false): void
    {
        $this->insert([
            'dish_id' => $itemID,
            userColumn($isGuest) => $userID,
            'quantity' => $qty
        ]);
    }

    public function deleteFromCart($userID, $itemID, $isGuest = false): void
    {
        $this->delete()->where(userColumn($isGuest), $userID)->and('dish_id', $itemID)->execute();
    }

    // Get the cart items of a specific customer
    public function getCartItems($user_id = null, $isGuest = false): bool|array
    {
        if ($user_id == null) {
            $user_id = $_SESSION['user']->user_id;
        }
        $cartItems = $this->select()->where(userColumn($isGuest), $user_id)->fetchAll();
        $items = [];
        foreach ($cartItems as $item) {
            $dish = (new Dish)->getDishById($item->dish_id);
            $dish->quantity = $item->quantity;
            $items[] = $dish;
        }
        return $items;
    }

    public function getNoOfItems($user_id = null, $isGuest = false): int
    {
        if ($user_id == null) {
            $user_id = $_SESSION['user']->user_id;
        }
        $cart = $this->count("*")->where(userColumn($isGuest), $user_id)->fetch();
        return $cart->{'COUNT(*)'};
    }

    public function getQty($user_id, $dish_id, $isGuest = false): int
    {
        $qty = $this->select()->where(userColumn($isGuest), $user_id)->and('dish_id', $dish_id)->fetch();
        if (!$qty) {
            return 0;
        }
        return $qty->quantity;
    }

    public function editCartItemQty($user_id, $dish_id, $qty, $isGuest = false): void
    {
        $this->update(['quantity' => $qty])->where(userColumn($isGuest), $user_id)
            ->and('dish_id', $dish_id)->execute();
    }

    public function clearCart($user_id, $isGuest = false): void
    {
        $this->delete()->where(userColumn($isGuest), $user_id)->execute();
    }

    public function moveCartToRegistered($guest_id, $reg_customer_id): void
    {
        $this->update(['reg_customer_id' => $reg_customer_id, 'guest_id' => null])
            ->where('guest_id', $guest_id)->execute();
    }

<<<<<<< HEAD
    public function clearCart($user_id): void
    {
        $this->delete()->where('user_id', $user_id)->execute();
=======
    /**
     * @param $user_id
     * @param $isGuest = false
     * @return float
     * Description: Calculates the total cost of the cart based on the dishes and their quantities without promotion or service charge
     */
    public function calculateSubTotal($user_id, $isGuest): float
    {
        $dishes = $this->getCartItems($user_id, $isGuest);
        $total = 0;
        foreach ($dishes as $dish) {
            $total += $dish->selling_price * $dish->quantity;
        }
        return $total;
    }

    /**
     * @param $user_id
     * @param $isGuest
     * @param $ordertype
     * @param int $promotion
     * @return float
     * Description: Calculates the total cost of the cart based on the dishes and their quantities with promotion and service charge
     */
    public function calculateTotal($user_id, $isGuest, $ordertype, int $promotion=1): float{
        $total = $this->calculateSubTotal($user_id, $isGuest);
        if ($promotion != 1) {
            $total = $total - (new Promotion())->reducedCostCart($user_id, $isGuest,$promotion);
        }
        if ($ordertype == "dine-in") {
            $total = $total + $total * 0.05;
        }
        return $total;
>>>>>>> f89be9ccaf1258b7066f4b2dd4a3fd47ca3e46b2
    }
}