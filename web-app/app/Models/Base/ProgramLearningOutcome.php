<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\CloPiMapping;
use App\Models\Base\PerformanceIndicator;
use App\Models\Base\Program;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgramLearningOutcome
 *
 * @property int $id
 * @property int|null $program_id
 * @property string|null $code
 * @property string $description
 *
 * @property Program|null $program
 * @property Collection|CloPiMapping[] $clo_pi_mappings
 * @property Collection|PerformanceIndicator[] $performance_indicators
 *
 * @package App\Models\Base\Base
 */
class ProgramLearningOutcome extends Model
{
	protected $table = 'program_learning_outcomes';
	public $timestamps = false;

	protected $casts = [
		'program_id' => 'int'
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}

	public function clo_pi_mappings()
	{
		return $this->hasMany(CloPiMapping::class, 'plo_id');
	}

	public function performance_indicators()
	{
		return $this->hasMany(PerformanceIndicator::class, 'plo_id');
	}
}
