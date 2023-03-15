<?php


namespace controllers\admin;

use core\Controller;
use models\Order;
use models\Menu;
use models\MenuDishes;
use models\Dish;
use models\Guest;



class Payments
{
    use Controller;

    private string $controller = "items";

    public function index(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/payments', $results);
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['dishes'] = $order->getDishes($order_id);
        $data['order'] = $order->getOrder($order_id);
        $this->view('admin/payments.detail', $data);
    }


    public function addOrder(): void
    {
        $d = new Dish();
        $m = new Menu();
        $m2 = new MenuDishes();
      
       
        $data['controller'] = 'menus';
        $data['dishes'] = $d->getDishes();

        $this->view('admin/payments.addOrder',$data);
    }

    public function Guest(): void
    {
        $Guest = new Guest();
        $results['username'] = $Guest->getGuest();
        $this->view('admin/payments', $results);
         
    }

    public function paidHistory(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/payments.paidHistory', $results);
    }
    

    


   

   
}
