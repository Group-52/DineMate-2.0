<?php
class Promotions
{
    use Controller;

    public function index(): void
    {
        $m = new Promotion();
        $p = $m->getpromotion(1);
        $this->view('promotions.view', ['promo' => $p]);
    }
}