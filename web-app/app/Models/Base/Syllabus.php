<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\AiComplianceReport;
use App\Models\Base\AiGenerationLog;
use App\Models\Base\ApprovedSyllabusCorpu;
use App\Models\Base\Course;
use App\Models\Base\CourseLearningOutcome;
use App\Models\Base\CourseObjective;
use App\Models\Base\SyllabusAssignment;
use App\Models\Base\SyllabusContent;
use App\Models\Base\SyllabusHistory;
use App\Models\Base\SyllabusOutcome;
use App\Models\Base\SyllabusPiTarget;
use App\Models\Base\SyllabusPloTarget;
use App\Models\Base\SyllabusTemplate;
use App\Models\Base\SyllabusVersion;
use App\Models\Base\TeachingPlanItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Syllabus
 *
 * @property int $id
 * @property int $course_id
 * @property int $template_id
 * @property string $academic_year
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $status_id
 * @property string|null $planning_note
 * @property Carbon|null $assigned_at
 * @property Carbon|null $due_date
 *
 * @property Course $course
 * @property SyllabusTemplate $syllabus_template
 * @property Collection|SyllabusContent[] $syllabus_contents
 * @property Collection|SyllabusHistory[] $syllabus_histories
 * @property Collection|SyllabusOutcome[] $syllabus_outcomes
 * @property Collection|SyllabusVersion[] $syllabus_versions
 * @property Collection|ApprovedSyllabusCorpu[] $approved_syllabus_corpus
 * @property Collection|CourseObjective[] $course_objectives
 * @property Collection|CourseLearningOutcome[] $course_learning_outcomes
 * @property Collection|AiGenerationLog[] $ai_generation_logs
 * @property Collection|AiComplianceReport[] $ai_compliance_reports
 * @property Collection|SyllabusPloTarget[] $syllabus_plo_targets
 * @property Collection|SyllabusPiTarget[] $syllabus_pi_targets
 * @property Collection|SyllabusAssignment[] $syllabus_assignments
 * @property Collection|TeachingPlanItem[] $teaching_plan_items
 *
 * @package App\Models\Base\Base
 */
class Syllabus extends Model
{
	protected $table = 'syllabuses';

	protected $casts = [
		'course_id' => 'int',
		'template_id' => 'int',
		'created_by' => 'int',
		'status_id' => 'int',
		'assigned_at' => 'datetime',
		'due_date' => 'datetime'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function syllabus_template()
	{
		return $this->belongsTo(SyllabusTemplate::class, 'template_id');
	}

	public function syllabus_contents()
	{
		return $this->hasMany(SyllabusContent::class);
	}

	public function syllabus_histories()
	{
		return $this->hasMany(SyllabusHistory::class);
	}

	public function syllabus_outcomes()
	{
		return $this->hasMany(SyllabusOutcome::class);
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class);
	}

	public function approved_syllabus_corpus()
	{
		return $this->hasMany(ApprovedSyllabusCorpu::class);
	}

	public function course_objectives()
	{
		return $this->hasMany(CourseObjective::class);
	}

	public function course_learning_outcomes()
	{
		return $this->hasMany(CourseLearningOutcome::class);
	}

	public function ai_generation_logs()
	{
		return $this->hasMany(AiGenerationLog::class);
	}

	public function ai_compliance_reports()
	{
		return $this->hasMany(AiComplianceReport::class);
	}

	public function syllabus_plo_targets()
	{
		return $this->hasMany(SyllabusPloTarget::class);
	}

	public function syllabus_pi_targets()
	{
		return $this->hasMany(SyllabusPiTarget::class);
	}

	public function syllabus_assignments()
	{
		return $this->hasMany(SyllabusAssignment::class);
	}

	public function teaching_plan_items()
	{
		return $this->hasMany(TeachingPlanItem::class);
	}
}
