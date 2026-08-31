<?php

namespace App\Models;

use App\Core\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    public function forOrder($orderId)
    {
        return $this->where('order_id', $orderId);
    }
}
