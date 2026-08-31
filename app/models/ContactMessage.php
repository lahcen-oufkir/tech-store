<?php

namespace App\Models;

use App\Core\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    public function unread()
    {
        return $this->where('is_read', 0);
    }

    public function unreadCount()
    {
        return (int) $this->db->value(
            "SELECT COUNT(*) FROM contact_messages WHERE is_read = 0"
        );
    }

    public function recent($limit = 10)
    {
        return $this->db->fetchAll(
            "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT {$limit}"
        );
    }

    public function markRead($id)
    {
        return $this->update($id, ['is_read' => 1]);
    }
}
