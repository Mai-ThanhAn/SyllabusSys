<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use App\Models\Base\TeachingPlanCloMapping;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TeachingPlanItem
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $item_order
 * @property string $title
 * @property string|null $content
 * @property string|null $teaching_activities
 * @property string|null $learning_activities
 * @property string|null $assessment_activities
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Syllabus $syllabus
 * @property Collection|TeachingPlanCloMapping[] $teaching_plan_clo_mappings
 *
 * @package App\Models\Base\Base
 */
class TeachingPlanItem extends Model
{
	protected $table = 'teaching_plan_items';

	protected $casts = [
		'syllabus_id' => 'int',
		'item_order' => 'int',
		'content' => 'binary',
		'teaching_activities' => 'binary',
		'learning_activities' => 'binary',
		'assessment_activities' => 'binary'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function teaching_plan_clo_mappings()
	{
		return $this->hasMany(TeachingPlanCloMapping::class);
	}
}
