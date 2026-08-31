<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function findBySlug($slug)
    {
        return $this->firstWhere('slug', $slug);
    }

    public function withProductCount()
    {
        return $this->db->fetchAll(
            "SELECT c.*, COUNT(p.id) AS product_count
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id AND p.is_active = 1
             GROUP BY c.id
             ORDER BY c.name"
        );
    }
}
