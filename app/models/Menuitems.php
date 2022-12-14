<?php


class MenuItems extends Model
{
    protected string $table = 'menu_items';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];


    public function getDishes($menu): bool|array
    {
        return $this->select()->fetchAll();
    }

    public function addMenu($data)
    {
        $this->insert($data);
    }

}

