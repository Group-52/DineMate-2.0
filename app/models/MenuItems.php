<?php


class MenuItems extends Model
{
    protected string $table = 'menu_items';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];


    public function getMenuItems($menu_id): array
    {
        $d = new Dish();

        $records = $this->select()->where('menu_id', $menu_id)->fetchAll();
        $menu_items = array();
        foreach ($records as $r) {
            if ($r->menu_id == $menu_id) {
                $menu_items[] = $d->getDishById($r->dish_id);
            }
        }
        return $menu_items;
    }

    #get all menu items and sort and separate by menu and make an array of arrays of menu items

    public function getMenuItemsByMenu(): array
    {
        $m = new Menu();
        $menus = $m->getMenus();
        $m_ids = array();

        foreach ($menus as $menu) {
            $m_ids[$menu->menu_id] = $this->getMenuItems($menu->menu_id);
        }
        return $m_ids;
    }

    public function addMenu($data): void
    {
        $this->insert($data);
    }
}

