<?php

namespace models;
// Sub Promotions class for the discounts promotion

class PromotionsDiscounts extends \Model
{

    public string $order_column = "promo_id";
    protected string $table = 'promo_discounts';
    protected array $allowedColumns = [
        'promo_id',
        'dish_id',
        'discount',
    ];

    // Get all entries in the table and return as an array where the key is the promo_id
    public function getpromos(): bool|array
    {
        $l = $this->select()->fetchAll();
        $promos = array();
        foreach ($l as $p) {
            $promos[$p->promo_id] = $p;
        }
        return $promos;
    }

    // Add a new entry to the promo_discounts table given the promo_id, dish_id and discount
    public function addpromotion($pid, $d, $disc)
    {
        $this->insert([
            'promo_id' => $pid,
            'dish_id' => $d,
            'discount' => $disc,
        ]);
    }

    // get one promotion by id
    public function getpromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        return $l;
    }
}
