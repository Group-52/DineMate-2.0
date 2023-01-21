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
        $l = $this->select()->fetchAll();
        $menus = array();
        foreach ($l as $m) {
            $menus[$m->menu_id] = $m;
        }
        return $menus;
    }

    public function addMenu($data)
    {
        $this->insert([
            'menu_name' => $data['name'],
            'description' => $data['description'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'image_url' => $data['image_url'],
            'all_day' => $data['all_day']
        ]);
    }

}

