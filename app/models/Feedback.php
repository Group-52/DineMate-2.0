<?php

namespace models;

use core\Model;

class Feedback extends Model
{

    public function __construct()
    {
        $this->table = "feedback";
        $this->columns = [
            "feedback_id",
            "order_id",
            "rating",
            "description",
        ];
    }
    // TODO Add join to order table
    /**
     * Get all Feedbacks.
     */
    public function getFeedback(): bool|array
    {
        $l = $this->select(["feedback.*","reg_users.first_name","reg_users.last_name","reg_users.user_id","orders.time_placed"])
            ->join('orders', 'orders.order_id', 'feedback.order_id')
        ->join("reg_users", "reg_users.user_id", "orders.reg_customer_id")
        ->fetchAll();
        $fb = array();
        foreach ($l as $f) {
            $fb[$f->feedback_id] = $f;
        }
        return $fb;
    }

    /**
     * Get a feedback by ID and Type
     * Types are feedback_id, reg_customer_id, guest_id, order_id
     * e.g. if id = 3 and type = "reg_customer_id" then it will return all feedbacks by customer with id 3
     *
     * @param int $id
     * @param string $type
     * @return array|bool
     */
    public function getFeedbackById(int $id, string $type = "feedback_id"): false|object
    {
        return $this->select()->where($type, $id)->fetch();
    }

    /**
     * Add a Feedback.
     * @return void
     */
    public function addFeedback(int $id, bool $is_registered, int $order_id, int $rating, string $desc): void
    {
        $this->insert([
            "reg_customer_id" => ($is_registered) ? $id : null,
            "guest_id" => (!$is_registered) ? $id : null,
            "order_id" => $order_id,
            "rating" => $rating,
            "description" => $desc
        ]);
    }
    public function getAll($sd,$ed):array
    {
        $sd = date("Y-m-d H:i:s", strtotime($sd));
        $ed = date("Y-m-d H:i:s", strtotime($ed));
        return $this->select(["feedback.*","reg_users.first_name","reg_users.last_name","reg_users.user_id","orders.time_placed"])
            ->join('orders', 'orders.order_id', 'feedback.order_id')
            ->join("reg_users", "reg_users.user_id", "orders.reg_customer_id")
            ->where("orders.time_placed", $sd, ">=")
            ->and("orders.time_placed", $ed, "<=")
            ->fetchAll();
    }

    public function editFeedback(int $feedbackId, int $rating, string $desc): void
    {
        $this->update([
            "rating" => $rating,
            "description" => $desc
        ])->where("feedback_id", $feedbackId)->execute();
    }
}

