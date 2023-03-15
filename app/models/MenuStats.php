<?php

namespace models;

// Menu stats class
use core\Model;

class MenuStats extends Model
{

    public string $order_column = "id";
    protected string $table = 'menu_statistics';
    protected array $allowedColumns = [
        'id',
        'menu_id',
        'date',
        'mcount',
    ];

    //get grouped sums for menu sales in a given date range
    public function getMenuStats($start_date, $end_date): array
    {
        $this->query = "SELECT menu_id, SUM(mcount) AS mcount FROM $this->table WHERE date BETWEEN '$start_date' AND '$end_date'GROUP BY menu_id";
        $counts = $this->fetchAll();
        $menus = ((new Menu())->getMenus());
        $menuids = array_keys($menus);
        $data = [];
        foreach ($counts as $count) {
            $data[$count->menu_id] = [
                'menu_name' => $menus[$count->menu_id]->menu_name,
                'mcount' => $count->mcount,
            ];
        }
        return $data;
    }

    public function getAll(): array
    {
        $this->select(['date','menu_id','mcount'])->orderBy('date', 'DESC');
        return $this->fetchAll();
    }


}

