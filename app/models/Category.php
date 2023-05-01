<?php

namespace models;

use core\Model;

class Category extends Model
{
    public function __construct()
    {
        $this->table = "categories";
        $this->columns = [
            "category_id",
            "category_name"
        ];
    }

    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->select()->fetchAll();
    }
}