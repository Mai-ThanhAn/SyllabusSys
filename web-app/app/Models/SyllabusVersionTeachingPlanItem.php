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
}
