<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\Program;
use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusRagCorpu
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property int|null $program_id
 * @property int|null $course_id
 * @property string $section_code
 * @property string $content_text
 * @property string|null $embedding
 * @property Carbon|null $created_at
 *
 * @property Syllabus|null $syllabus
 * @property Program|null $program
 * @property Course|null $course
 *
 * @package App\Models\Base\Base
 */
class SyllabusRagCorpu extends Model
{
	protected $table = 'syllabus_rag_corpus';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'program_id' => 'int',
		'course_id' => 'int',
		'embedding' => 'binary'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function program()
	{
		return $this->belongsTo(Program::class);
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
