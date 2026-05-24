<?php

namespace App\Models;

use App\Models\Base\TeachingPlanItem as BaseTeachingPlanItem;

class TeachingPlanItem extends BaseTeachingPlanItem
{
    protected $fillable = [
        'syllabus_id',
        'item_order',
        'title',
        'content',
        'teaching_activities',
        'learning_activities',
        'assessment_methods',
    ];
    protected $casts = [
    'content' => 'array',
    'teaching_activities' => 'array',
    'learning_activities' => 'array',
    'assessment_activities' => 'array',
];
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
