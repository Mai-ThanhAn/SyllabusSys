<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\CourseLearningOutcome;
use App\Models\Base\TeachingPlanItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TeachingPlanCloMapping
 *
 * @property int $id
 * @property int $teaching_plan_item_id
 * @property int $clo_id
 * @property Carbon|null $created_at
 *
 * @property TeachingPlanItem $teaching_plan_item
 * @property CourseLearningOutcome $course_learning_outcome
 *
 * @package App\Models\Base\Base
 */
class TeachingPlanCloMapping extends Model
{
	protected $table = 'teaching_plan_clo_mappings';
	public $timestamps = false;

	protected $casts = [
		'teaching_plan_item_id' => 'int',
		'clo_id' => 'int'
	];

	public function teaching_plan_item()
	{
		return $this->belongsTo(TeachingPlanItem::class);
	}

	public function course_learning_outcome()
	{
		return $this->belongsTo(CourseLearningOutcome::class, 'clo_id');
	}
}
