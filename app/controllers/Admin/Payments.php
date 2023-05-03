<?php


namespace controllers\admin;

use core\Controller;
use models\Order;
use models\Menu;
use models\MenuDishes;
use models\Dish;
use models\RegUser;
use models\Guest;



class Payments
{
    use Controller;

    private string $controller = "payments";

    public function index(): void
    {
        $order = new Order;
        $data['tobepaid'] = array_merge($order->getTodayCashierOrders(0,0,"completed"),$order->getTodayCashierOrders(0,0,"accepted"),$order->getTodayCashierOrders(0,0,"pending"));
        $data['tobecollected']= array_merge($order->getTodayCashierOrders(1),$order->getTodayCashierOrders(1,0,"accepted"),$order->getTodayCashierOrders(1,0,"pending"));
        $data['controller'] = $this->controller;
        $this->view('admin/payments', $data);
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['dishes'] = $order->getDishes($order_id);
        $data['order'] = $order->getOrder($order_id);
        if($data['order'] == false)
            redirect('admin/404');
        $this->view('admin/payments.detail', $data);
    }


    public function addOrder(): void
    {
        if(isset($_POST['add-dish-button'])){
        
        }
        $d = new Dish();
        $m = new Menu();
        $m2 = new MenuDishes();
      
       
        $data['controller'] = 'menus';
        $data['dishes'] = $m2->getDishes();

    //    $RegUser = new RegUser();
    //    $data['username'] = $RegUser->getReguser($RegUser);

        $this->view('admin/payments.addOrder',$data);
    }


    public function create(): void
    {
        if(isset($_POST['submit-button'])){
          
			$first_name = $_POST['fname'];
			$last_name = $_POST['lname'];
			$contact_no = $_POST['contact_no'];
			$email = $_POST['email'];

			$guest = new Guest;
			$guest ->createGuest([
                
				'first_name'=> $first_name,
                'last_name'=> $last_name,
				'contact_no'=> $contact_no,
				'email'=> $email
			]);

            redirect('admin/payments');

        }
        $this->view('admin/payments');
    }
    

    


   

   
}
