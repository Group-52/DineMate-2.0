<?php

// Menu class

class Menu extends Model
{

    public string $order_column = "menu_id";
    protected string $table = 'menus';
    protected string $primary_key = 'menu_id';
    protected array $allowedColumns = [
        'menu_id',
        'name',
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
        $l= $this->findAll();
        $menus = array();
        foreach ($l as $m) {
            $menus[$m->menu_id] = $m;
        }
        return $menus;
    }

    public function addMenu($data)
    {
        $this->insert($data);
    }

}

