<?php

namespace controllers\admin;

use core\Controller;
use models\Guest;
use models\Order;
use models\InventoryDetail;
use models\RegUser;

/**
 * Class Guests
 */
class Users
{
    use Controller;

    public function index(): void
    {
        $guest = new Guest;
        $r = new RegUser();
        $data['reg'] = $r->getReg();
        $data['guest'] = $guest->getGuest();
        $data['block'] = $r->getBlacklist();
        $data['controller'] = 'users';
        $this->view('admin/user', $data);
    }

    public function profile($id): void
    {
        $r = new RegUser();
        $om = new Order();
        $temp1 = $om->getPreviousOrders($id, 1000);
        $total = 0;
        if ($temp1) {
            foreach ($temp1 as $order) {
                $total += $order->total_cost;
            }
        }
        $data['user'] = $r->getUserById($id);
        if ($data['user'] == false) {
            redirect('admin/users');
        }
        $data['prev_orders'] = $temp1;

        $data['active_orders'] = $om->getActiveOrders($id, 100);
        if ($total == 0) {
            $data['average_value'] = 0;
        } else {
            $data['average_value'] = ceil($total / count($temp1));
        }
        $data['controller'] = 'users';

        $this->view('admin/user.profile', $data);
    }

    public function blacklist(): void
    {
        $r = new RegUser();
        $id = $_GET['bl_id'];
        $bl = $_GET['bl'];
        $r->blacklist($id, $bl);
        redirect('admin/users');
    }
}