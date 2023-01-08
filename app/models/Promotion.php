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

    // Get all entries in the promotions table
    public function getpromos(): bool|array
    {
        $query = "SELECT * FROM promotions p
        JOIN (
          CASE
            WHEN p.type = 'spending_bonus' THEN promotions_spendingbonus
            WHEN p.type = 'discounts' THEN promotions_discounts
            WHEN p.type = 'free_dish' THEN promotions_buy1get1free
          END
        ) t2 ON p.promo_id = t2.promo_id";
        $this->query = $query;
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
    public function getpromotion($id): bool|array
    {
        $l = $this->select()->where('promo_id', $id)->fetch();
        // $type = $l->type;        
        

        return $l;
    }

}

// public function join(string $table, string $column1, string $column2, string $operator = "="): Model
// {
//     $this->query .= " JOIN $table ON $column1 $operator $column2";
//     return $this;
// }

// return $this->select(["item_id", "item_name", "description", "units.unit_name AS units_name", "categories.category_name AS category_name"])
//             ->join("units", "unit", "unit_id")
//             ->join("categories", "category", "category_id")
//             ->containsAll($likeData)
//             ->and("categories.category_name", $data["category"] ?? "")
//             ->fetchAll();

// SELECT *
// FROM table1 t1
// JOIN (
//   SELECT *
//   FROM
//     CASE
//       WHEN column1 = 'value1' THEN table2
//       WHEN column1 = 'value2' THEN table3
//       ELSE table4
//     END
// ) t2 ON t1.id = t2.id
