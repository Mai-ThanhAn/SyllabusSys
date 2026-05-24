<?php

namespace App\Models;

use App\Models\Base\CourseLearningOutcome as BaseCourseLearningOutcome;

class CourseLearningOutcome extends BaseCourseLearningOutcome
{
    protected $fillable = [
        'syllabus_id',
        'code',
        'description',
        'bloom_level',
        'mapped_co',
        'mapped_pi',
    ];
}
