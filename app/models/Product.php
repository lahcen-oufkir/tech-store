<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected $table = 'products';

    public function findBySlug($slug)
    {
        return $this->firstWhere('slug', $slug);
    }

    /** All products with category names (used by the admin panel). */
    public function adminAll()
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.created_at DESC"
        );
    }

    /** Search all products (admin panel, includes inactive). */
    public function adminSearch($q)
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.name LIKE ? OR p.description LIKE ?
             ORDER BY p.created_at DESC",
            ["%{$q}%", "%{$q}%"]
        );
    }

    public function active()
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1
             ORDER BY p.created_at DESC"
        );
    }

    public function featured()
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.is_featured = 1
             ORDER BY p.created_at DESC
             LIMIT 8"
        );
    }

    public function byCategory($categoryId)
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.category_id = ?
             ORDER BY p.created_at DESC",
            [$categoryId]
        );
    }

    public function search($q, $categoryId = null)
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.is_active = 1
                  AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)";
        $bind = ["%{$q}%", "%{$q}%", "%{$q}%"];

        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $bind[] = $categoryId;
        }

        $sql .= " ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql, $bind);
    }

    public function related($productId, $categoryId, $limit = 4)
    {
        return $this->db->fetchAll(
            "SELECT * FROM products
             WHERE is_active = 1 AND id <> ? AND category_id = ?
             ORDER BY is_featured DESC
             LIMIT {$limit}",
            [$productId, $categoryId]
        );
    }

    /** Detach products from a category (used when a category is deleted). */
    public function updateByCategory($categoryId)
    {
        return $this->db->run(
            "UPDATE products SET category_id = NULL WHERE category_id = ?",
            [$categoryId]
        );
    }

    /** Reduce stock after an order. */
    public function decrementStock($id, $quantity)
    {
        return $this->db->run(
            "UPDATE products SET stock = stock - ? WHERE id = ?",
            [$quantity, $id]
        );
    }

    /** Reduce stock, but only when the current stock is enough. */
    public function decrementStockSafely($id, $quantity)
    {
        return $this->db->run(
            "UPDATE products SET stock = stock - ?
             WHERE id = ? AND stock >= ?",
            [$quantity, $id, $quantity]
        );
    }

    public function withCategoryName($id)
    {
        return $this->db->fetch(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id = ?
             LIMIT 1",
            [$id]
        );
    }
}
