<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApprovedSyllabusCorpu
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property int|null $course_id
 * @property string|null $course_name
 * @property string|null $course_type
 * @property int|null $credits
 * @property string|null $raw_content
 * @property array|null $structured_json
 * @property USER-DEFINED|null $embedding
 * @property Carbon|null $approved_at
 *
 * @property Syllabus|null $syllabus
 * @property Course|null $course
 *
 * @package App\Models\Base\Base
 */
class ApprovedSyllabusCorpu extends Model
{
	protected $table = 'approved_syllabus_corpus';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'course_id' => 'int',
		'credits' => 'int',
		'structured_json' => 'json',
		'embedding' => 'USER-DEFINED',
		'approved_at' => 'datetime'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
