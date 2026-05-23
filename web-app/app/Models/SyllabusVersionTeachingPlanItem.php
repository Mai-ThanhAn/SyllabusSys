<?php

namespace App\Models;

use App\Models\Base\SyllabusVersionTeachingPlanItem as BaseSyllabusVersionTeachingPlanItem;

class SyllabusVersionTeachingPlanItem extends BaseSyllabusVersionTeachingPlanItem
{
    protected $fillable = [
        'version_id',
        'item_order',
        'title',
        'content',
        'teaching_activities',
        'learning_activities',
        'assessment_activities'
    ];
    public function cloMappings()
    {
        return $this->hasMany(
            SyllabusVersionTeachingPlanCloMapping::class,
            'version_teaching_plan_item_id'
        );
    }
}
