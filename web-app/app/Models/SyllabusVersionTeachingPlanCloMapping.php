<?php

namespace App\Models;

use App\Models\Base\SyllabusVersionTeachingPlanCloMapping as BaseSyllabusVersionTeachingPlanCloMapping;

class SyllabusVersionTeachingPlanCloMapping extends BaseSyllabusVersionTeachingPlanCloMapping
{
	protected $fillable = [
		'version_teaching_plan_item_id',
		'clo_code'
	];
}
