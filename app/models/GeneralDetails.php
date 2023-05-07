<?php

namespace models;

use core\Model;

class GeneralDetails extends Model
{
    protected int $nrows = 30;

    public function __construct()
    {
        $this->table = "general_info";
        $this->columns = [
            "restaurant_name",
            "opening_time",
            "closing_time",
            "email",
            "contact_no",
            "twitter_url",
            "instagram_url",
            "introduction",
            "background_image_url",
            "favicon_url",
            "logo_url",
            "kitchen_staff",
            "max_guest_bill",
            "max_nonbulk"
        ];
    }

    public function getDetails(): object|false
    {
        return $this->select()->fetch();
    }
    public function updateDetails($data)
    {
        $this->update($data)->execute();
    }
    public function insertDetails(array $data): void
    {
        $this->insert($data);
    }
    public function deleteDetails():void
    {
        $this->delete()->execute();
    }


}

