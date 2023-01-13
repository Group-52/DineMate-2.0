<?php

class Feedback extends Model
{

    public function __construct()
    {
        $this->table = "feedback";
        $this->columns = [
            "feedback_id",
            "reg_customer_id",
            "guest_id",
            "order_id",
            "rating",
            "description",
            "time_placed"            
        ];
    }

    /**
     * Get all Feedbacks.
     */
    public function getFeedback(): bool|array
    {
        $l = $this->select()->fetchAll();
        $fb = array();
        foreach($l as $f) {
            $fb[$f->feedback_id] = $f;
        }
        return $fb;
    }

    // get a feedback by id and type
    // Types are feedback_id, reg_customer_id, guest_id, order_id
    // eg. if id = 3 and type = "reg_customer_id" then it will return all feedbacks by customer with id 3
    public function getFeedbackById($id,$type = "feedback_id")
    {
        return $this->select()->where($type,$id)->fetchAll();
    }

    /**
     * Add a Feedback.
     * @return void
     */
    
    public function addFeedback($regid, $guestid = null, $orderid,$rating,$desc): void
    {
        $this->insert([
            "reg_customer_id" => $regid,
            "guest_id" => $guestid,
            "order_id" => $orderid,
            "rating" => $rating,
            "description" => $desc
        ]);
    }
}

