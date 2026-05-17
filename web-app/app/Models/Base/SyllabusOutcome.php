<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\LearningOutcome;
use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusOutcome
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $outcome_id
 * @property Carbon|null $created_at
 *
 * @property Syllabus $syllabus
 * @property LearningOutcome $learning_outcome
 *
 * @package App\Models\Base\Base
 */
class SyllabusOutcome extends Model
{
	protected $table = 'syllabus_outcomes';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'outcome_id' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function learning_outcome()
	{
		return $this->belongsTo(LearningOutcome::class, 'outcome_id');
	}
}
