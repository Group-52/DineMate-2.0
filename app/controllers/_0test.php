<?php
class _0test
{
    use Controller;

    public function index(): void
    {
        $m = new Promotions();
        $p = $m->getpromotion(1);
        $this->view('test', ['promo' => $p]);
    }
}