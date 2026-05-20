<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusVersion;
use App\Models\Base\SyllabusVersionTeachingPlanCloMapping;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersionTeachingPlanItem
 *
 * @property int $id
 * @property int $version_id
 * @property int $item_order
 * @property string $title
 * @property string|null $content
 * @property string|null $teaching_activities
 * @property string|null $learning_activities
 * @property string|null $assessment_activities
 * @property Carbon|null $created_at
 *
 * @property SyllabusVersion $syllabus_version
 * @property Collection|SyllabusVersionTeachingPlanCloMapping[] $syllabus_version_teaching_plan_clo_mappings
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersionTeachingPlanItem extends Model
{
	protected $table = 'syllabus_version_teaching_plan_items';
	public $timestamps = false;

	protected $casts = [
		'version_id' => 'int',
		'item_order' => 'int',
		'content' => 'binary',
		'teaching_activities' => 'binary',
		'learning_activities' => 'binary',
		'assessment_activities' => 'binary'
	];

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}

	public function syllabus_version_teaching_plan_clo_mappings()
	{
		return $this->hasMany(SyllabusVersionTeachingPlanCloMapping::class, 'version_teaching_plan_item_id');
	}
}
