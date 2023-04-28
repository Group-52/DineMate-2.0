<?php

// Main Promotion class
namespace models;

// Main Promotions class

use core\Model;

class Promotion extends Model
{

    public string $order_column = "promo_id";

    public function __construct()
    {
        $this->table = "promotions";
        $this->columns = [
            "promo_id",
            "title",
            "type",
            "status",
            "description",
            "image_url",
            "deleted"
        ];
    }

    public function getAllPromotions()
    {
        $a1 = $this->getDiscounts();
        $a2 = $this->getSpendingBonus();
        $a3 = $this->getFreeDish();
        return array_merge($a1, $a2, $a3);
    }

    public function getDiscounts()
    {
        return $this->select(["promotions.*", "promo_discounts.*", "dishes.dish_name"])->
        join('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        join('dishes', 'promo_discounts.dish_id', 'dishes.dish_id')->
        where('promotions.type', 'discounts')->
        and('promotions.deleted', 0)->
        and('dishes.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }

    public function getSpendingBonus()
    {
        return $this->select(["promotions.*", "promo_spending_bonus.*"])->
        join('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        where('promotions.type', 'spending_bonus')->
        and('promotions.deleted', 0)->
        and('dishes.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }

    public function getFreeDish()
    {
        return $this->select(["promotions.*", "promo_buy1get1free.*", "dishes1.dish_name as dish1_name", "dishes2.dish_name as dish2_name"])->
        join('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id')->
        join('dishes as dishes1', 'promo_buy1get1free.dish1_id', 'dishes1.dish_id')->
        join('dishes as dishes2', 'promo_buy1get1free.dish2_id', 'dishes2.dish_id')->
        where('promotions.type', 'free_dish')->
        and('promotions.deleted', 0)->
        and('dishes1.deleted', 0)->
        orderBy('status', 'DESC')->fetchAll();
    }


    // Add a new entry to the promotions table and sub tables
    public function addpromotion($data)
    {
        $this->insert([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => $data['status'],
            'image_url' => $data['image_url']
        ]);

        $data['promo_id'] = $this->select(['promo_id'])->where('title', $data['title'])->
        and('type', $data['type'])->fetch()->promo_id;

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
    public function getpromotion($id)
    {
        return $this->select()->
        leftJoin('promo_discounts', 'promotions.promo_id', 'promo_discounts.promo_id')->
        leftJoin('promo_spending_bonus', 'promotions.promo_id', 'promo_spending_bonus.promo_id')->
        leftJoin('promo_buy1get1free', 'promotions.promo_id', 'promo_buy1get1free.promo_id')->
        where('promotions.promo_id', $id)->and('promotions.deleted', 0)->fetch();
    }

    public function deletepromo($id)
    {
        $this->update(["deleted" => 1])->where('promo_id', $id)->execute();
    }

    public function editpromo($data)
    {
        $this->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => $data['status'],
        ])->where('promo_id', $data['promo_id'])->execute();
        if ($data['type'] == 'spending_bonus') {
            $obj = new PromotionsSpendingBonus();
            $obj->editpromotion($data['promo_id'], $data['spent_amount'], $data['bonus_amount']);
        } else if ($data['type'] == 'discounts') {
            $obj = new PromotionsDiscounts();
            $obj->editpromotion($data['promo_id'], $data['dish_id'], $data['discount']);
        } else if ($data['type'] == 'free_dish') {
            $obj = new PromotionsBuy1Get1Free();
            $obj->editpromotion($data['promo_id'], $data['dish1_id'], $data['dish2_id']);
        }
    }

}
