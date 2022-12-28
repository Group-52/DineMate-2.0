<?php

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