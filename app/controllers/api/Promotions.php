<?php

namespace controllers\api;

use core\Controller;
use models\Dish;

class Promotions
{
    use Controller;

    public function getValidPromotions(): void
    {
        $p = new \models\Promotion();
        $post = json_decode(file_get_contents('php://input'));
        $utype = $post->utype == 'guest';
        $userid = $post->uid;
        if ($utype == 'guest') {
            $plist =  $p->getValidPromotionsCart($userid, true);
        } else {
            $plist= $p->getValidPromotionsCart($userid, false);
        }

        $this->json([
            'status' => 'success',
            'promotions' => $plist
        ]);
    }

    public function getReduction():void{
        $p = new \models\Promotion();
        $post = json_decode(file_get_contents('php://input'));
        $utype = $post->utype=='guest';
        $userid = $post->uid;
        $promo = $post->promo;
        $reduction = $p->reducedCostCart($userid, $utype, $promo);
        $this->json([
            'status' => 'success',
            'reduction' => $reduction
        ]);
    }


}