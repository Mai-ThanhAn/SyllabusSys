<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\AiComplianceReport;
use App\Models\Base\Status;
use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusApproval;
use App\Models\Base\SyllabusHistory;
use App\Models\Base\SyllabusVersionContent;
use App\Models\Base\SyllabusVersionCourseLearningOutcome;
use App\Models\Base\SyllabusVersionCourseObjective;
use App\Models\Base\SyllabusVersionTeachingPlanItem;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersion
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $version_number
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property string|null $submission_type
 * @property int|null $base_version_id
 * @property int|null $status_id
 * @property string|null $note
 * @property string|null $ai_change_summary
 *
 * @property Syllabus $syllabus
 * @property User|null $user
 * @property \App\Models\Base\SyllabusVersion|null $syllabus_version
 * @property Status|null $status
 * @property Collection|SyllabusApproval[] $syllabus_approvals
 * @property Collection|SyllabusHistory[] $syllabus_histories
 * @property Collection|SyllabusVersionContent[] $syllabus_version_contents
 * @property Collection|\App\Models\Base\SyllabusVersion[] $syllabus_versions
 * @property Collection|AiComplianceReport[] $ai_compliance_reports
 * @property Collection|SyllabusVersionCourseObjective[] $syllabus_version_course_objectives
 * @property Collection|SyllabusVersionCourseLearningOutcome[] $syllabus_version_course_learning_outcomes
 * @property Collection|SyllabusVersionTeachingPlanItem[] $syllabus_version_teaching_plan_items
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersion extends Model
{
	protected $table = 'syllabus_versions';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'version_number' => 'int',
		'created_by' => 'int',
		'base_version_id' => 'int',
		'status_id' => 'int',
		'ai_change_summary' => 'binary'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function syllabus_version()
	{
		return $this->belongsTo(\App\Models\Base\SyllabusVersion::class, 'base_version_id');
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class, 'version_id');
	}

	public function syllabus_histories()
	{
		return $this->hasMany(SyllabusHistory::class, 'to_version_id');
	}

	public function syllabus_version_contents()
	{
		return $this->hasMany(SyllabusVersionContent::class, 'version_id');
	}

	public function syllabus_versions()
	{
		return $this->hasMany(\App\Models\Base\SyllabusVersion::class, 'base_version_id');
	}

	public function ai_compliance_reports()
	{
		return $this->hasMany(AiComplianceReport::class, 'version_id');
	}

	public function syllabus_version_course_objectives()
	{
		return $this->hasMany(SyllabusVersionCourseObjective::class, 'version_id');
	}

	public function syllabus_version_course_learning_outcomes()
	{
		return $this->hasMany(SyllabusVersionCourseLearningOutcome::class, 'version_id');
	}

	public function syllabus_version_teaching_plan_items()
	{
		return $this->hasMany(SyllabusVersionTeachingPlanItem::class, 'version_id');
	}
}
