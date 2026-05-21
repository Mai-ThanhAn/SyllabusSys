<?php

namespace App\Models;

use App\Models\Base\Department as BaseDepartment;

class Department extends BaseDepartment
{
    public function head()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }
}
