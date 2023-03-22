<?php

namespace controllers\admin;

use core\Controller;
use models\Promotion;
use models\Dish;

class Promotions
{
    use Controller;

    public function index(): void
    {

        $data = [];
        $data['controller'] = 'promotions';

        $p = new Promotion();
        $d = new Dish();

        $data['dishes'] = $d->getDishes();
        $data['discount'] = $p->getDiscounts();
        $data['spending_bonus'] = $p->getSpendingBonus();
        $data['free_dish'] = $p->getFreeDish();

        $this->view('admin/promotions', $data);
    }

    public function delete(): void
    {
        $p = new Promotion();
        $p->deletepromo($_GET['promoid']);
        redirect('admin/promotions');
    }
}
