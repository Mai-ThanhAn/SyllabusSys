<?php

namespace App\Models;

use App\Models\Base\TeachingPlanCloMapping as BaseTeachingPlanCloMapping;

class TeachingPlanCloMapping extends BaseTeachingPlanCloMapping
{
    public function teachingPlanItem()
    {
        return $this->belongsTo(TeachingPlanItem::class);
    }

    public function clo()
    {
        return $this->belongsTo(CourseLearningOutcome::class, 'clo_id');
    }
}
