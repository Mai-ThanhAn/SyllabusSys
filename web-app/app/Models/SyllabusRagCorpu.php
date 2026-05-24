<?php

namespace App\Models\Base;

use App\Models\Base\Base\SyllabusRagCorpu as BaseSyllabusRagCorpu;

class SyllabusRagCorpu extends BaseSyllabusRagCorpu
{
	protected $fillable = [
		'syllabus_id',
		'program_id',
		'course_id',
		'section_code',
		'content_text',
		'embedding'
	];
}
