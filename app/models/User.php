<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        return $this->firstWhere('email', $email);
    }

    public function customers()
    {
        return $this->where('role', 'customer');
    }

    public function orderCount($userId)
    {
        return (int) $this->db->value(
            "SELECT COUNT(*) FROM orders WHERE user_id = ?",
            [$userId]
        );
    }
}
