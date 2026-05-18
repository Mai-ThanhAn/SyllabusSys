<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\ProgramLearningOutcome;
use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusPloTarget
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $plo_id
 * @property Carbon|null $created_at
 *
 * @property Syllabus $syllabus
 * @property ProgramLearningOutcome $program_learning_outcome
 *
 * @package App\Models\Base\Base
 */
class SyllabusPloTarget extends Model
{
	protected $table = 'syllabus_plo_targets';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'plo_id' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function program_learning_outcome()
	{
		return $this->belongsTo(ProgramLearningOutcome::class, 'plo_id');
	}
}
