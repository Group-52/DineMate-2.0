<?php

namespace models;

use core\Model;

class Category extends Model
{
    public function __construct()
    {
        $this->table = "categories";
        $this->columns = [
            "category_name"
        ];
    }
}