<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function findByNumber($orderNumber)
    {
        return $this->firstWhere('order_number', $orderNumber);
    }

    public function byUser($userId)
    {
        return $this->where('user_id', $userId);
    }

    public function withItems($id)
    {
        $order = $this->find($id);
        if (!$order) {
            return null;
        }
        $order['items'] = (new OrderItem())->forOrder($id);
        return $order;
    }

    public function recent($limit = 10)
    {
        return $this->db->fetchAll(
            "SELECT * FROM orders ORDER BY created_at DESC LIMIT {$limit}"
        );
    }

    public function countByStatus()
    {
        $rows = $this->db->fetchAll(
            "SELECT status, COUNT(*) AS total FROM orders GROUP BY status"
        );
        return array_column($rows, 'total', 'status');
    }

    /** Monthly revenue grouped by month for the dashboard chart. */
    public function revenueByMonth($limit = 6)
    {
        return $this->db->fetchAll(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month,
                    SUM(total) AS revenue,
                    COUNT(*) AS orders
             FROM orders
             WHERE status <> 'cancelled'
             GROUP BY month
             ORDER BY month DESC
             LIMIT {$limit}"
        );
    }

    public function totalRevenue()
    {
        return (float) $this->db->value(
            "SELECT COALESCE(SUM(total), 0) FROM orders WHERE status <> 'cancelled'"
        );
    }
}
