<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\CourseLearningOutcome;
use App\Models\Base\PerformanceIndicator;
use App\Models\Base\ProgramLearningOutcome;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CloPiMapping
 *
 * @property int $id
 * @property int|null $clo_id
 * @property int|null $plo_id
 * @property int|null $pi_id
 * @property string|null $contribution_level
 *
 * @property CourseLearningOutcome|null $course_learning_outcome
 * @property ProgramLearningOutcome|null $program_learning_outcome
 * @property PerformanceIndicator|null $performance_indicator
 *
 * @package App\Models\Base\Base
 */
class CloPiMapping extends Model
{
	protected $table = 'clo_pi_mappings';
	public $timestamps = false;

	protected $casts = [
		'clo_id' => 'int',
		'plo_id' => 'int',
		'pi_id' => 'int'
	];

	public function course_learning_outcome()
	{
		return $this->belongsTo(CourseLearningOutcome::class, 'clo_id');
	}

	public function program_learning_outcome()
	{
		return $this->belongsTo(ProgramLearningOutcome::class, 'plo_id');
	}

	public function performance_indicator()
	{
		return $this->belongsTo(PerformanceIndicator::class, 'pi_id');
	}
}
