<?php

namespace App\Models;

use App\Models\CourseLearningOutcome;
use App\Models\Base\TeachingPlanCloMapping as BaseTeachingPlanCloMapping;

class TeachingPlanCloMapping extends BaseTeachingPlanCloMapping
{
    protected $fillable = [
        'teaching_plan_item_id',
        'clo_id',
    ];
    public function teachingPlanItem()
    {
        return $this->belongsTo(TeachingPlanItem::class);
    }

    public function clo()
    {
        return $this->belongsTo(CourseLearningOutcome::class, 'clo_id');
    }
}
