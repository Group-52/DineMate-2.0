<?php

namespace controllers;

use core\Controller;
use components\Form;
use models\Cart;
use models\Dish;
use models\GeneralDetails;
use models\Order;
use models\PromotionsBuy1Get1Free;
use models\PromotionsDiscounts;
use models\PromotionsSpendingBonus;
use models\RegUser;
use WebSocket\Client;

class Checkout
{
    use Controller;

    public function index(): void
    {
        $cart = new Cart();
        $cartItems = $cart->getCartItems(userId(), isGuest());
        if (empty($cartItems)) {
            redirect("cart");
        }

        $data = [];
        $data["title"] = "Checkout";

        // Form building
        $form = new Form("", "POST", "Checkout");
        $form->addSelectField("order-type", "order-type", "Type of Order",true, ["dine-in" => "Dine-In", "takeaway" => "Take Away"], "Type of Order");
        if (isRegistered()) {
            $form->addInputField("schedule-order", "schedule-order", "checkbox", "Schedule Order", false, "Schedule Order", "", false);
            $form->addInputField("schedule-time", "schedule-time", "datetime-local", "Schedule Time", false, "Schedule Time", date("Y-m-d H:i"), true);
        }
        $form->addInputField("table-number", "table-number", "number", "Table Number", false, "", "", true, [
            "min" => 1
        ]);
        $form->addInputField("request", "request", "text", "Request", false, "Less spicy, no salt, etc.");
        $form->addSelectField("tip", "tip", "Tip",true, ["0" => "0%", "0.05" => "5%", "0.1" => "10%", "0.15" => "15%"]);
        if (isGuest()) {
            $form->addInputField("full-name", "full-name", "text", "Full Name", true, "Full Name");
            $form->addInputField("mobile", "mobile", "text", "Mobile", true, "Mobile");
            $form->addInputField("email", "email", "email", "Email", true, "Email");
        }

        // Get promotion details
        $promo_id = 1;
        if (isRegistered()) {
            $promo_id = (new RegUser())->getPromoId(userId());
        }
        else if (isGuest()) {
            $promo_id = (new \models\Guest())->getPromoId(userId());
        }

        $promotion = new \models\Promotion();
        $promotion_item = $promotion->getPromotion($promo_id);

        $promotion_type = null;
        $old_price = null;
        $new_price = null;
        $promotion_item_type = null;

        // Promotion details based on promotion type
        if ($promotion_item->type == "discounts") {
            $promotion_model = new PromotionsDiscounts();
            $promotion_discount = $promotion_model->getPromotion($promo_id);
            $dish = (new Dish)->getDishById($promotion_discount->dish_id);
            $old_price = $dish->selling_price;
            $new_price = $dish->selling_price - $promotion_discount->discount;
            $promotion_type = "Discounts";
            $promotion_item_type = $promotion_discount;
        } else if ($promotion_item->type == "spending_bonus") {
            $promotion_model = new PromotionsSpendingBonus();
            $promotion_spending_bonus = $promotion_model->getPromotion($promo_id);
            $old_price = $promotion_spending_bonus->spent_amount + $promotion_spending_bonus->bonus_amount;
            $new_price = $promotion_spending_bonus->spent_amount;
            $promotion_type = "Spending Bonus";
            $promotion_item_type = $promotion_spending_bonus;
        } else if ($promotion_item->type == "free_dish") {
            $promotion_model = new PromotionsBuy1Get1Free();
            $promotion_free_dish = $promotion_model->getPromotion($promo_id);
            $promotion_type = "Buy 1 Get 1 Free";
            $dish1 = (new Dish)->getDishById($promotion_free_dish->dish1_id);
            $dish2 = (new Dish)->getDishById($promotion_free_dish->dish2_id);
            $old_price = $dish1->selling_price + $dish2->selling_price;
            $new_price = $dish1->selling_price;
            $promotion_item_type = $promotion_free_dish;
        }
        $data["promotion"] = (object)array_merge((array)$promotion_item, (array)$promotion_item_type);
        $data["old_price"] = $old_price;
        $data["new_price"] = $new_price;
        $data["promotion"]->discount = $old_price - $new_price;

        $subtotal = 0;
        $discount = 0;
        $dish1Count = 0;
        $dish2Count = 0;

        // Calculate subtotal and discount
        foreach ($cartItems as $item) {
            if ($data["promotion"]->promo_id != 1) {
                if ($promotion_type == "Discounts") {
                    if ($item->dish_id == $data["promotion"]->dish_id) {
                        $discount += $data["promotion"]->discount * $item->quantity;
                    }
                } else if ($promotion_type == "Buy 1 Get 1 Free") {
                    if ($item->dish_id == $data["promotion"]->dish1_id) {
                        $dish1Count += $item->quantity;
                    } else if ($item->dish_id == $data["promotion"]->dish2_id) {
                        $dish2Count += $item->quantity;
                    }
                }
            }
            $subtotal += $item->quantity * $item->selling_price;
        }
        if ($promotion_type == "Buy 1 Get 1 Free") {
            if ($data["promotion"]->dish1_id == $data["promotion"]->dish2_id) {
               $discount += floor(($dish1Count + $dish2Count) / 2) * $data["promotion"]->discount;
            } else {
                $discount += min($dish1Count, $dish2Count) * $data["promotion"]->discount;
            }
        }
        if ($promotion_type == "Spending Bonus") {
            if ($subtotal >= $data["promotion"]->spent_amount) {
                $discount += $data["promotion"]->bonus_amount;
            }
        }
        $data["discount"] = $discount;
        $data["subtotal"] = $subtotal;
        $total = $subtotal - $discount;
        $data["total"] = $total;

        $maxBulkAmt = 0;
        if (isset($footer_details)) {
            $maxBulkAmt = $footer_details->max_nonbulk;
        }

        // Place order
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($form->isValid($_POST)) {
                $cart = new Cart();
                $cart_items = $cart->getCartItems(userId(), isGuest());
                $order = new Order();
                $orderType = $_POST["order-type"];
                $serviceCharge = 0;
                if ($orderType == "dine-in")
                   $serviceCharge = $subtotal * 0.05;
                $order_id = $order->create($orderType, $cart_items, reg_customer_id: (isRegistered()) ? userId() : null,
                    guest_id: (isGuest()) ? userId() : null, request: $_POST["request"], table_id: $_POST["table-number"] ?? null,
                    scheduled_time: isset($_POST["schedule-order"]) ? $_POST["schedule-time"] : null, total_cost: $total,
                    promo: $promo_id, service_charge: $serviceCharge ,tip: $subtotal * $_POST["tip"]);

                if ($order->getErrors()) {
                    $data["errors"] = $order->getErrors();
                    $data["error"] = "Order could not be placed";
                } else {
                    $data["success"] = "Order placed successfully";

                    $ws = new Client("ws://" . SERVER_SOCKET_HOST . ":8080");
                    $ws->text(json_encode([
                        "event_type" => "new_order",
                        "data" => [
                            "order_id" => $order_id,
                            "status" => "pending",
                            "time_placed" => date("Y-m-d H:i:s"),
                            "request" => $_POST["request"],
                            "user_id" => userId(),
                            "user_type" => (isRegistered()) ? "registered" : "guest",
                            "type" => $orderType,
                            "scheduled_time" => $_POST["schedule-time"] ?? null,
                            "table_id" => $_POST["table-number"] ?? null,
                            "order_dishes" => $cart_items
                        ]
                    ]));
                    if (isLoggedIn())
                        $cart->clearCart(userId(), isGuest());
                    redirect("orders");
                }
            } else {
                $data["errors"] = $form->getErrors();
                $data["error"] = "Order could not be placed";
            }
        }
        $data["footer_details"] = (new GeneralDetails())->getFooterDetails();
        $data["form"] = $form;
        $data["cart"] = $cartItems;
        $this->view("checkout", $data);
    }
}
