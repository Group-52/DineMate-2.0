<?php


namespace controllers\admin;

use core\Controller;
use models\Cart;
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
        $data['tobepaid'] = array_merge($order->getTodayCashierOrders(0, 0, "completed"), $order->getTodayCashierOrders(0, 0, "accepted"), $order->getTodayCashierOrders(0, 0, "pending"));
        $data['tobecollected'] = array_merge($order->getTodayCashierOrders(1), $order->getTodayCashierOrders(1, 0, "accepted"), $order->getTodayCashierOrders(1, 0, "pending"));
        $data['controller'] = $this->controller;
        $data['userlist'] = (new RegUser)->getReg();
        $this->view('admin/payments', $data);
    }

    public function id($order_id): void
    {
        $order = new Order;
        $data['dishes'] = $order->getDishes($order_id);
        $orderobj = $order->getOrder($order_id);
        $data['order'] = $orderobj;
        $data['subtotal'] = $order->calculateSubTotal($order_id);
        if ($orderobj->paid == 1) {
            $data['net_total'] = $orderobj->total_cost;
            $data['sv_charge'] = $orderobj->service_charge;
        }else{
            $data['net_total'] = $order->calculateFullTotal($order_id);
            $data['sv_charge'] = $order->calculateSubTotal($order_id)*0.05;
        }
        if ($data['order'] == false)
            redirect('admin/404');
        $data['controller'] = $this->controller;
        $this->view('admin/payments.detail', $data);
    }

    public function create(): void
    {
        if (isset($_POST['submit-button'])) {

            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $contact_no = $_POST['contact_no'];
            $email = $_POST['email'];

            $guest = new Guest;
            $guest->createGuest([

                'first_name' => $first_name,
                'last_name' => $last_name,
                'contact_no' => $contact_no,
                'email' => $email
            ]);

            redirect('admin/payments');
        }
        $data['controller'] = $this->controller;
        $this->view('admin/payments');
    }

    public function addOrder(): void
    {
        //get parameter
        $utype = $_GET['utype'] ?? "registered";
        $email = $_GET['email'] ?? null;
        $data=[];
        if ($email){
            $user = new RegUser;
            $user = $user->getUserByEmail($email);
            if ($user){
                $data['fname'] = $user->first_name;
                $data['lname'] = $user->last_name;
                $data['contact_no'] = $user->contact_no;
                $data['email'] = $user->email;
                $data['reg_user_id'] = $user->user_id;
            }
        }
        if ($utype == "guest") {
            $guest = new Guest;
            if (!isset($_SESSION['guest_id'])) {
                $guestId = $guest->createGuest();
                $_SESSION['guest_id'] = $guestId;
            } else {
                $guestId = $_SESSION['guest_id'];
                //clear the cart for the guest
                $c = new Cart;
                $c->clearCart($guestId, true);
            }
        }

        $m2 = new MenuDishes();
        $data['controller'] = $this->controller;
        $temp = $m2->getDishes();
        $dm = new Dish();
        $temp2 =[];
        foreach ($temp as $t){
            if ($dm->safeToAdd($t->dish_id))
                $temp2[] = $t;
        }
        $data['dishes'] = $temp2;
        $this->view('admin/payments.addOrder', $data);
    }
}
