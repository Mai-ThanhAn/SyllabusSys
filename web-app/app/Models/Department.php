<?php

namespace App\Models;

use App\Models\Base\Department as BaseDepartment;

class Department extends BaseDepartment
{
    protected $fillable = [
        'department_name',
        'university_id',
        'head_user_id',
        'created_at',
    ];

    public function head()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }
}
