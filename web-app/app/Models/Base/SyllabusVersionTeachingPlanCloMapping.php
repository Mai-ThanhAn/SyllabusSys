<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusVersionTeachingPlanItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersionTeachingPlanCloMapping
 *
 * @property int $id
 * @property int $version_teaching_plan_item_id
 * @property string $clo_code
 * @property Carbon|null $created_at
 *
 * @property SyllabusVersionTeachingPlanItem $syllabus_version_teaching_plan_item
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersionTeachingPlanCloMapping extends Model
{
	protected $table = 'syllabus_version_teaching_plan_clo_mappings';
	public $timestamps = false;

	protected $casts = [
		'version_teaching_plan_item_id' => 'int'
	];

	public function syllabus_version_teaching_plan_item()
	{
		return $this->belongsTo(SyllabusVersionTeachingPlanItem::class, 'version_teaching_plan_item_id');
	}
}
