<?php

namespace App\Models;

use App\Models\Base\Course as BaseCourse;

class Course extends BaseCourse
{
    protected $fillable = [
        'course_code',
        'course_name',
        'credits',
        'program_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
