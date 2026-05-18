<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\CloPiMapping;
use App\Models\Base\Syllabus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseLearningOutcome
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property string|null $code
 * @property string $description
 * @property int|null $bloom_level
 *
 * @property Syllabus|null $syllabus
 * @property Collection|CloPiMapping[] $clo_pi_mappings
 *
 * @package App\Models\Base\Base
 */
class CourseLearningOutcome extends Model
{
	protected $table = 'course_learning_outcomes';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'bloom_level' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function clo_pi_mappings()
	{
		return $this->hasMany(CloPiMapping::class, 'clo_id');
	}
}
