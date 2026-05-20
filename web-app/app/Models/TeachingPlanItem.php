<?php

namespace App\Models;

use App\Models\Base\TeachingPlanItem as BaseTeachingPlanItem;

class TeachingPlanItem extends BaseTeachingPlanItem
{
    public function cloMappings()
    {
        return $this->hasMany(TeachingPlanCloMapping::class);
    }

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }
    public function teachingPlanItems()
    {
        return $this->hasMany(TeachingPlanItem::class);
    }
}
