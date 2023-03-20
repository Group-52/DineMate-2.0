<?php

namespace models;

use core\Model;

class GeneralDetails extends Model
{
    protected int $nrows = 15;

    public function __construct()
    {
        $this->table = "general_info";
        $this->columns = [
            "restaurant_name",
            "opening_time",
            "closing_time",
            "email",
            "contact_no",
            "introduction",
            "image_url",
            "kitchen_staff"

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
    public function insert(array $data): void
    {
        $this->insert($data);
    }
    public function delete():Model
    {
        return $this->delete()->execute();
    }


}

