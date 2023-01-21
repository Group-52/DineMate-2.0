<?php

namespace models;

// Main Promotions class

use Model;

class Promotions extends Model
{

    public string $order_column = "promo_id";
    protected string $table = 'promotions';
    protected array $allowedColumns = [
        'promo_id',
        'caption',
        'type',
        'status',
    ];

    // Get all entries in the promotions table
    public function getpromos(): bool|array
    {
        $l = $this->select()->fetchAll();
        $promos = array();
        foreach ($l as $p) {
            $promos[$p->promo_id] = $p;
        }
        return $promos;
    }

    // Add a new entry to the promotions table and sub tables
    public function addpromotion($data)
    {
        $this->insert([
            'caption' => $data['caption'],
            'type' => $data['type'],
            'status' => $data['status'],
        ]);

        // check for type of promotion and add to the respective table

        if ($data['type'] == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $obj->addpromotion($data['promo_id'], $data['spent_amount'], $data['bonus_amount']);
        } else if ($data['type'] == 'discounts') {
            $obj = new PromotionsDiscounts();
            $obj->addpromotion($data['promo_id'], $data['dish_id'], $data['discount']);
        } else if ($data['type'] == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $obj->addpromotion($data['promo_id'], $data['dish1_id'], $data['dish2_id']);
        }
    }

    // get one promotion by id
    public function getpromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();

        $l = $this->select()->where('promo_id', $id)->fetch();

        return $l;
    }

}

// public function join(string $table, string $column1, string $column2, string $operator = "="): Model
// {
//     $this->query .= " JOIN $table ON $column1 $operator $column2";
//     return $this;
// }

