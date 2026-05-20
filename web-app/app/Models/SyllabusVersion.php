<?php

namespace App\Models;

use App\Models\Base\SyllabusVersion as BaseSyllabusVersion;

class SyllabusVersion extends BaseSyllabusVersion
{
    protected $casts = [
        'ai_change_summary' => 'array',
    ];
    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contents()
    {
        return $this->hasMany(SyllabusVersionContent::class, 'version_id');
    }

    public function courseObjectives()
    {
        return $this->hasMany(SyllabusVersionCourseObjective::class, 'version_id');
    }

    public function courseLearningOutcomes()
    {
        return $this->hasMany(SyllabusVersionCourseLearningOutcome::class, 'version_id');
    }

    public function teachingPlanItems()
    {
        return $this->hasMany(SyllabusVersionTeachingPlanItem::class, 'version_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function approvals()
    {
        return $this->hasMany(SyllabusApproval::class, 'version_id');
    }
}
