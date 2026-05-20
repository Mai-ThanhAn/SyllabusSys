<?php

namespace App\Models;

use App\Models\Base\SyllabusVersionCourseObjective as BaseSyllabusVersionCourseObjective;

class SyllabusVersionCourseObjective extends BaseSyllabusVersionCourseObjective
{
	protected $fillable = [
		'version_id',
		'code',
		'description',
		'bloom_level'
	];
}
