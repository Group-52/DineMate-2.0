<?php


class Menuitems extends Model
{

    public string $order_column = "menu_id";
    protected string $table = 'menu_items';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];


    public function getDishes($menu): bool|array
    {
        return $this->findAll();
    }

    public function addMenu($data)
    {
        $this->insert($data);
    }

}

