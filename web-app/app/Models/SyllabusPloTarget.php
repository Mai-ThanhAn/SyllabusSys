<?php

namespace App\Models;

use App\Models\Base\SyllabusPloTarget as BaseSyllabusPloTarget;

class SyllabusPloTarget extends BaseSyllabusPloTarget
{
    protected $fillable = [
    'syllabus_id',
    'plo_id',
];
public function syllabus()
    {
        return $this->belongsTo(
            Syllabus::class,
            'syllabus_id'
        );
    }

    public function programLearningOutcome()
    {
        return $this->belongsTo(
            ProgramLearningOutcome::class,
            'plo_id'
        );
    }
}
