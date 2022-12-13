<?php

// Menu class

class Menu extends Model
{

    public string $order_column = "menu_id";
    protected string $table = 'menus';
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
        return $this->findAll();
    }

    public function addMenu($data)
    {
        $this->insert($data);
    }

}

