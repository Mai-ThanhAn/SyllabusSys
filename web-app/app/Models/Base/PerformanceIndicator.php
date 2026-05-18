<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\CloPiMapping;
use App\Models\Base\ProgramLearningOutcome;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PerformanceIndicator
 *
 * @property int $id
 * @property int|null $plo_id
 * @property string|null $code
 * @property string $description
 *
 * @property ProgramLearningOutcome|null $program_learning_outcome
 * @property Collection|CloPiMapping[] $clo_pi_mappings
 *
 * @package App\Models\Base\Base
 */
class PerformanceIndicator extends Model
{
	protected $table = 'performance_indicators';
	public $timestamps = false;

	protected $casts = [
		'plo_id' => 'int'
	];

	public function program_learning_outcome()
	{
		return $this->belongsTo(ProgramLearningOutcome::class, 'plo_id');
	}

	public function clo_pi_mappings()
	{
		return $this->hasMany(CloPiMapping::class, 'pi_id');
	}
}
