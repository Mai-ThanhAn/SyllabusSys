<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionOutcomeSuggestion
 * 
 * @property int $id
 * @property int|null $section_id
 * @property int|null $outcome_id
 * @property int|null $recommendation_level
 * @property Carbon|null $created_at
 * 
 * @property SyllabusSection|null $syllabus_section
 * @property LearningOutcome|null $learning_outcome
 *
 * @package App\Models
 */
class SectionOutcomeSuggestion extends Model
{
	protected $table = 'section_outcome_suggestions';
	public $timestamps = false;

	protected $casts = [
		'section_id' => 'int',
		'outcome_id' => 'int',
		'recommendation_level' => 'int'
	];

	protected $fillable = [
		'section_id',
		'outcome_id',
		'recommendation_level'
	];

	public function syllabus_section()
	{
		return $this->belongsTo(SyllabusSection::class, 'section_id');
	}

	public function learning_outcome()
	{
		return $this->belongsTo(LearningOutcome::class, 'outcome_id');
	}
}
