<?php

namespace App\Models;

use App\Core\Model;

class Service extends Model
{
    protected $table = 'services';

    public function active()
    {
        return $this->where('is_active', 1);
    }
}
