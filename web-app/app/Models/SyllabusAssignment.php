<?php

namespace App\Models;

use App\Models\Base\SyllabusAssignment as BaseSyllabusAssignment;

class SyllabusAssignment extends BaseSyllabusAssignment
{
    protected $fillable = [
    'syllabus_id',
    'user_id',
    'assignment_role',
    'assigned_by',
];
public function user()
{
    return $this->belongsTo(User::class);
}
}
