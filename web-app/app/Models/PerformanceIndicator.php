<?php

namespace App\Models;

use App\Models\Base\PerformanceIndicator as BasePerformanceIndicator;

class PerformanceIndicator extends BasePerformanceIndicator
{
    protected $fillable = [
        'plo_id',
        'code',
        'description',
    ];
    public function programLearningOutcome()
    {
        return $this->belongsTo(ProgramLearningOutcome::class, 'plo_id');
    }
}
