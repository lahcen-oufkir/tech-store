<?php

namespace App\Models;

use App\Core\Model;

class RepairRequest extends Model
{
    protected $table = 'repair_requests';

    public function byUser($userId)
    {
        return $this->where('user_id', $userId);
    }

    public function recent($limit = 10)
    {
        return $this->db->fetchAll(
            "SELECT * FROM repair_requests ORDER BY created_at DESC LIMIT {$limit}"
        );
    }

    public function countByStatus()
    {
        $rows = $this->db->fetchAll(
            "SELECT status, COUNT(*) AS total FROM repair_requests GROUP BY status"
        );
        return array_column($rows, 'total', 'status');
    }
}
