<?php

namespace App\Models;

use App\Models\Base\Syllabus as BaseSyllabus;

class Syllabus extends BaseSyllabus
{

    protected $fillable = [
        'course_id',
        'template_id',
        'academic_year',
        'status_id',
        'created_by',
    ];
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
    public function approvals()
    {
        return $this->hasManyThrough(
            SyllabusApproval::class,
            SyllabusVersion::class,
            'syllabus_id',
            'version_id',
            'id',
            'id'
        );
    }
    public function assignments()
    {
        return $this->hasMany(SyllabusAssignment::class);
    }
    public function template()
    {
        return $this->belongsTo(SyllabusTemplate::class, 'template_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function contents()
    {
        return $this->hasMany(
            SyllabusContent::class,
            'syllabus_id'
        );
    }
    public function ploTargets()
    {
        return $this->hasMany(
            SyllabusPloTarget::class,
            'syllabus_id'
        );
    }
    public function programLearningOutcome()
    {
        return $this->belongsTo(ProgramLearningOutcome::class, 'plo_id');
    }
public function piTargets()
{
    return $this->hasMany(SyllabusPiTarget::class, 'syllabus_id');
}
}
