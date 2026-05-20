<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusVersion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersionCourseLearningOutcome
 *
 * @property int $id
 * @property int $version_id
 * @property string $code
 * @property string $description
 * @property string|null $bloom_level
 * @property Carbon|null $created_at
 *
 * @property SyllabusVersion $syllabus_version
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersionCourseLearningOutcome extends Model
{
	protected $table = 'syllabus_version_course_learning_outcomes';
	public $timestamps = false;

	protected $casts = [
		'version_id' => 'int'
	];

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}
}
