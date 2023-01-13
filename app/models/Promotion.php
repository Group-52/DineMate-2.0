<?php

// Main Promotion class

class Promotion extends Model
{

    public string $order_column = "promo_id";
    protected string $table = 'promotions';
    protected array $allowedColumns = [
        'promo_id',
        'caption',
        'type',
        'status',
    ];

    // Get all entries in the promotions table, optionally give a type to filter queries and get only one type of promotions
    // Types are 'spending_bonus', 'discounts' and 'free_dish'
    public function getpromos($type = null)
    {
        $q = $this->select()->
        leftJoin('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        leftJoin('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        leftJoin('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id');
        
        if ($type != null)
            return $q->where('promotions.type', $type)->fetchAll();
        else
            return $q->fetchAll();
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
            $obj = new Promotions_spendingbonus();
            $obj->addpromotion($data['promo_id'], $data['spent_amount'], $data['bonus_amount']);
        } else if ($data['type'] == 'discounts') {
            $obj = new Promotions_discounts();
            $obj->addpromotion($data['promo_id'], $data['dish_id'], $data['discount']);
        }else if ($data['type'] == 'free_dish') {
            $obj = new Promotions_buy1get1free();
            $obj->addpromotion($data['promo_id'], $data['dish1_id'], $data['dish2_id']);
        }
    }

    // get one promotion by id
    public function getpromotion($id)
    {
        return $this->select()->
        leftJoin('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        leftJoin('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        leftJoin('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id')->
        where('promotions.promo_id', $id);
    }

}

