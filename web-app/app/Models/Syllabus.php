<?php

namespace App\Models;

use App\Models\Base\Syllabus as BaseSyllabus;

class Syllabus extends BaseSyllabus
{
    public function courseObjectives()
    {
        return $this->hasMany(CourseObjective::class);
    }
    public function courseLearningOutcomes()
    {
        return $this->hasMany(CourseLearningOutcome::class);
    }
    public function teachingPlanItems()
    {
        return $this->hasMany(TeachingPlanItem::class);
    }
}
