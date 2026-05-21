<?php

namespace App\Models;

use App\Models\Base\CourseObjective as BaseCourseObjective;

class CourseObjective extends BaseCourseObjective
{
    protected $fillable = [
    'syllabus_id',
    'code',
    'description',
    'bloom_level',
];
}
