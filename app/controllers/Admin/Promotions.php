<?php

namespace controllers\admin;

use core\Controller;
use models\Promotion;

class Promotions
{
    use Controller;

    public function index(): void
    {

        $data = [];
        $data['controller'] = 'promotions';

        $p = new Promotion();

        $data['discount'] = $p->getDiscounts();

        $data['spending_bonus'] = $p->getSpendingBonus();

        $data['free_dish'] = $p->getFreeDish();

        $this->view('admin/promotions', $data);
    }
}
