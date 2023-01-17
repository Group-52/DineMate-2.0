<?php

namespace models;

// Sub Promotions class for the buy 1, get 1 free promotion

class PromotionsBuy1Get1Free extends \Model
{

    public string $order_column = "promo_id";
    protected string $table = 'promo_buy1get1free';
    protected array $allowedColumns = [
        'promo_id',
        'dish1_id',
        'dish2_id',
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

    // Add a new entry to the promos_get1buy1free table given the promo_id, dish1_id and dish2_id
    public function addpromotion($pid, $d1, $d2)
    {
        $this->insert([
            'promo_id' => $pid,
            'dish1_id' => $d1,
            'dish2_id' => $d2,
        ]);
    }

    // get one promotion by id
    public function getpromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        return $l;
    }
}
