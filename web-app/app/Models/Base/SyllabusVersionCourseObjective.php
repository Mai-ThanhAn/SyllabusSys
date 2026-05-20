<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusVersion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersionCourseObjective
 *
 * @property int $id
 * @property int $version_id
 * @property string $code
 * @property string $description
 * @property int|null $bloom_level
 * @property Carbon|null $created_at
 *
 * @property SyllabusVersion $syllabus_version
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersionCourseObjective extends Model
{
	protected $table = 'syllabus_version_course_objectives';
	public $timestamps = false;

	protected $casts = [
		'version_id' => 'int',
		'bloom_level' => 'int'
	];

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}
}
