<?php

namespace App\Models;

use App\Models\Base\SyllabusVersionCourseLearningOutcome as BaseSyllabusVersionCourseLearningOutcome;

class SyllabusVersionCourseLearningOutcome extends BaseSyllabusVersionCourseLearningOutcome
{
	protected $fillable = [
		'version_id',
		'code',
		'description',
		'bloom_level'
	];
}
