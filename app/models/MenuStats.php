<?php

namespace models;

// Menu stats class
use core\Model;

class MenuStats extends Model
{

    public string $order_column = "id";

    public function __construct()
    {
        $this->table = "menu_statistics";
        $this->columns = [
            "id",
            "menu_id",
            "date",
            "mcount"
        ];
    }

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
        $this->select(['date', 'menu_id', 'mcount'])->orderBy('date', 'DESC');
        return $this->fetchAll();
    }

    //given an order id, add the menu statistics to the table
    public function addOrder($id)
    {
        $om = new Order();
        $odm = new OrderDishes();
        $mm = new MenuDishes();
        $mids = [];
        $dishes = $odm->getOrderDishes($id);
        foreach ($dishes as $dish) {
            $temp_mid=$mm->getMenuOfDish($dish->dish_id);
            if($temp_mid){
                $mids[] = $temp_mid;
            }
        }
        $mids = array_unique($mids);
        $date = $om->getOrder($id)->time_placed;
        $date = date('Y-m-d', strtotime($date));

        foreach ($mids as $mid) {
            $this->plusOne($date, $mid);
        }
    }

    //add one to the menu count for a given date and menu id
    public function plusOne($date,$menu_id){
        $row = $this->select()->where('date',$date)->and('menu_id',$menu_id)->fetch();
        if($row){
            $this->update(['mcount'=>$row->mcount+1])
                ->where('date',$date)
                ->and('menu_id',$menu_id)->execute();
        }else{
            $this->insert([
                'date'=>$date,
                'menu_id'=>$menu_id,
                'mcount'=>1
            ]);
        }


    }

}

