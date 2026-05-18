<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\PerformanceIndicator;
use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusPiTarget
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $pi_id
 * @property Carbon|null $created_at
 *
 * @property Syllabus $syllabus
 * @property PerformanceIndicator $performance_indicator
 *
 * @package App\Models\Base\Base
 */
class SyllabusPiTarget extends Model
{
	protected $table = 'syllabus_pi_targets';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'pi_id' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function performance_indicator()
	{
		return $this->belongsTo(PerformanceIndicator::class, 'pi_id');
	}
}
