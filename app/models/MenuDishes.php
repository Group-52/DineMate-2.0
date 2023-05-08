<?php

namespace models;

use core\Model;

class MenuDishes extends Model
{
    public function __construct()
    {
      $this->table = 'menu_dishes';
        $this->columns = [
            'menu_id',
            'dish_id'
        ];
    }

    /**
     * @return array
     * Description: get all dishes that are assigned to a menu
     */
    public function getDishes():array
    {
        $q =  $this->select(['dishes.*'])->join('dishes','menu_dishes.dish_id','dishes.dish_id')->fetchAll();
        return array_unique($q,SORT_REGULAR);
    }

    // get all dishes for a menu
    public function getMenuDishes(int $menu_id, int $num = 100, int $offset = 0, $filterAvailable = false): array
    {
        $d = new Dish();

        $records = $this->select()
            ->join("dishes", "menu_dishes.dish_id","dishes.dish_id")
            ->where('menu_id', $menu_id)
            ->and('dishes.deleted', 0)
            ->limit($num)->offset($offset)->fetchAll();
        $menu_dishes = array();
        foreach ($records as $r) {
            if ($r->menu_id == $menu_id) {
                if ($filterAvailable) {
                    if ($d->safeToAdd($r->dish_id))
                        $menu_dishes[] = $d->getDishById($r->dish_id);
                } else {
                    $menu_dishes[] = $d->getDishById($r->dish_id);
                }
            }
        }

        return $menu_dishes;
    }

    public function addMenuDish($data): void
    {
        $this->insert([
            'menu_id' => $data['menu_id'],
            'dish_id' => $data['dish_id']
        ]);
    }

    //get menu id of a dish
    public function getMenuOfDish($dish_id){
        return $this->select()->where('dish_id',$dish_id)->fetch()->menu_id;
    }

    public function deleteDishes($menu_id,$dish_id)
    {
        $this->delete()->where('menu_id', $menu_id)->and('dish_id', $dish_id)->execute();
    }
}

