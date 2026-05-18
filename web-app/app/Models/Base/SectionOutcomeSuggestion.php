<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusSection;
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
 *
 * @package App\Models\Base\Base
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

	public function syllabus_section()
	{
		return $this->belongsTo(SyllabusSection::class, 'section_id');
	}
}
