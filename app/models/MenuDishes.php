<?php


class MenuDishes extends Model
{
    protected string $table = 'menu_dishes';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];


    // get all dishes in a menu
    public function getDishesforMenu($menuid){
        return $this->select(["menu_dishes.dish_id", "dishes.dish_name", "dishes.selling_price", "dishes.description", "dishes.image_url"])
        ->join("dishes", "dishes.dish_id", "menu_dishes.dish_id")
        ->where("menu_id", $menuid)
        ->fetchAll();
    }

    public function addMenuDish($menuid,$dishid): void
    {
        $this->insert([
            'menu_id' => $menuid,
            'dish_id' => $dishid
        ]);
    }
}

