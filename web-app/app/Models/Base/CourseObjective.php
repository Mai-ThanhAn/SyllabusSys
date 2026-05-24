<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseObjective
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property string|null $code
 * @property string $description
 * @property string|null $bloom_level
 *
 * @property Syllabus|null $syllabus
 *
 * @package App\Models\Base\Base
 */
class CourseObjective extends Model
{
	protected $table = 'course_objectives';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}
}
