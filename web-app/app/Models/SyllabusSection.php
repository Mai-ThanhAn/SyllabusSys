<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusSection
 * 
 * @property int $id
 * @property string $title
 * @property string|null $section_code
 * @property int|null $display_order
 * @property bool|null $is_required
 * @property int $template_id
 * @property bool|null $is_ai_generatable
 * 
 * @property SyllabusTemplate $syllabus_template
 * @property Collection|SectionOutcomeSuggestion[] $section_outcome_suggestions
 * @property Collection|SyllabusContent[] $syllabus_contents
 * @property Collection|SyllabusVersionContent[] $syllabus_version_contents
 *
 * @package App\Models
 */
class SyllabusSection extends Model
{
	protected $table = 'syllabus_sections';
	public $timestamps = false;

	protected $casts = [
		'display_order' => 'int',
		'is_required' => 'bool',
		'template_id' => 'int',
		'is_ai_generatable' => 'bool'
	];

	protected $fillable = [
		'title',
		'section_code',
		'display_order',
		'is_required',
		'template_id',
		'is_ai_generatable'
	];

	public function syllabus_template()
	{
		return $this->belongsTo(SyllabusTemplate::class, 'template_id');
	}

	public function section_outcome_suggestions()
	{
		return $this->hasMany(SectionOutcomeSuggestion::class, 'section_id');
	}

	public function syllabus_contents()
	{
		return $this->hasMany(SyllabusContent::class, 'section_id');
	}

	public function syllabus_version_contents()
	{
		return $this->hasMany(SyllabusVersionContent::class, 'section_id');
	}
}
