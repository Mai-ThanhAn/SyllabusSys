<?php

namespace App\Models;

use App\Models\Base\SyllabusPiTarget as BaseSyllabusPiTarget;

class SyllabusPiTarget extends BaseSyllabusPiTarget
{
    protected $fillable = [
    'syllabus_id',
    'pi_id',
];
public function performanceIndicator()
{
    return $this->belongsTo(
        PerformanceIndicator::class,
        'pi_id'
    );
}
}
