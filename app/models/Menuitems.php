<?php


class Menuitems extends Model
{

    public string $order_column = "menu_id";
    protected string $table = 'menu_items';
    protected string $primary_key = 'menu_id';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];


    #pass menu id to get all dishes in that menu
    public function getMenuItems($menu)
    {
        $d = new Dish();
        
        $records = $this->find($menu);
        $menuitems = array();
        foreach ($records as $r) {
            if ($r->menu_id == $menu) {
                $menuitems[] = $d->getDishById($r->dish_id)[0];
            }
        }
        return $menuitems;
    }

    #get all menu items and sort and separate by menu and make an array of arrays of menu items

    public function getMenuItemsByMenu()
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

    // public function addMenu($data)
    // {
    //     $this->insert($data);
    // }


}

