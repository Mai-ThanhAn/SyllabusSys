<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\SectionOutcomeSuggestion;
use App\Models\Base\SyllabusContentMapping;
use App\Models\Base\SyllabusOutcome;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LearningOutcome
 *
 * @property int $id
 * @property string $code
 * @property string $description
 * @property string|null $type
 * @property int|null $bloom_level
 * @property Carbon|null $created_at
 * @property int|null $course_id
 *
 * @property Course|null $course
 * @property Collection|SectionOutcomeSuggestion[] $section_outcome_suggestions
 * @property Collection|SyllabusContentMapping[] $syllabus_content_mappings
 * @property Collection|SyllabusOutcome[] $syllabus_outcomes
 *
 * @package App\Models\Base\Base
 */
class LearningOutcome extends Model
{
	protected $table = 'learning_outcomes';
	public $timestamps = false;

	protected $casts = [
		'bloom_level' => 'int',
		'course_id' => 'int'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function section_outcome_suggestions()
	{
		return $this->hasMany(SectionOutcomeSuggestion::class, 'outcome_id');
	}

	public function syllabus_content_mappings()
	{
		return $this->hasMany(SyllabusContentMapping::class, 'outcome_id');
	}

	public function syllabus_outcomes()
	{
		return $this->hasMany(SyllabusOutcome::class, 'outcome_id');
	}
}
