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
        $l = $this->select([
                "feedback.*", "orders.order_id",
                $this->concat(["reg_users.first_name","reg_users.last_name"], " ", "reg"),
                $this->concat(["guest_users.first_name","guest_users.last_name"], " ", "guest"),
                "orders.time_placed"
            ])
            ->join("orders", "orders.order_id", "feedback.order_id")
            ->leftJoin("reg_users", "reg_users.user_id", "orders.reg_customer_id")
            ->leftJoin("guest_users", "guest_users.guest_id", "orders.guest_id")
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
        return $this->select(["feedback.*","reg_users.first_name","reg_users.last_name"])
            ->join("reg_users", "reg_users.user_id", "feedback.reg_customer_id")
            ->where("feedback.time_placed", $sd, ">=")
            ->and("feedback.time_placed", $ed, "<=")
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

