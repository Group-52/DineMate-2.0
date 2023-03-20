<?php

namespace models;

// Menu class
use core\Model;

class Menu extends Model
{

    public string $order_column = "menu_id";
    protected string $table = 'menus';
    protected array $allowedColumns = [
        'menu_id',
        'menu_name',
        'description',
        'start_time',
        'end_time',
        'image_url',
        'all_day'
    ];

    public function validate($data): bool
    {
        $this->errors = [];

        if (empty($data['name']))
            $this->errors['name'] = 'Name is required';

        if (empty($this->errors))
            return true;

        return false;
    }

    public function getMenus(): bool|array
    {
        $l =  $this->select()->fetchAll();
        $menulist = array();
        foreach ($l as $m) {
            $menulist[$m->menu_id] = $m;
        }
        return $menulist;
    }

    // get all dishes for all menus and returns as an associative array 
    // with menu_id as key and array of dishes as value
    public function getDishesperMenu(){
        $dpm = new MenuDishes();
        $menus = $this->getMenus();
        $menudishes = array();
        foreach ($menus as $m) {
            $menudishes[$m->menu_id] = $dpm->getMenuDishes($m->menu_id);
        }
        return $menudishes;
    }


    public function add($data)
    {
        $this->insert($data);
    }

    public function getMenu($menu_id): object|bool
    {
        return $this->select()->where("menu_id", $menu_id)->fetch();
    }

    public function deleteMenu($data)
    {
        $this->delete()->where("menu_id", $data)->execute();
    }

}

