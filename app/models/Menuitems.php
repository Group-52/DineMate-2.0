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
        $d = new Dish();

        $records = $this->find($menu);
        return $this->select()->fetchAll();
        $menuitems = array();
        foreach ($records as $r) {
            if ($r->menu_id == $menu) {
                $menuitems[] = $d->getDishById($r->dish_id)[0];
            }
        }
        return $menuitems;
    }

    #get all menu items and sort and separate by menu and make an array of arrays of menu items

    public function getMenuItemsByMenu(): array
    {
        $m = new Menu();
        $menus = $m->getMenus();
        $menulist = array_values($menus);
        $mids = array();

        foreach ($menus as $menu) {
            $mids[$menu->menu_id] = $this->getMenuItems($menu->menu_id);
        }
        return $mids;
    }

     public function addMenu($data): void
     {
         $this->insert($data);
     }
}

