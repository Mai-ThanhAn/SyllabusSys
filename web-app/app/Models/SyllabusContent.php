<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusContent
 * 
 * @property int $id
 * @property int|null $syllabus_id
 * @property int|null $section_id
 * @property string|null $content_html
 * @property string|null $content_raw
 * @property float|null $alignment_score
 * @property float|null $similarity_score
 * @property string|null $ai_feedback
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Syllabus|null $syllabus
 * @property SyllabusSection|null $syllabus_section
 * @property Collection|SyllabusContentMapping[] $syllabus_content_mappings
 *
 * @package App\Models
 */
class SyllabusContent extends Model
{
	protected $table = 'syllabus_contents';

	protected $casts = [
		'syllabus_id' => 'int',
		'section_id' => 'int',
		'content_raw' => 'binary',
		'alignment_score' => 'float',
		'similarity_score' => 'float'
	];

	protected $fillable = [
		'syllabus_id',
		'section_id',
		'content_html',
		'content_raw',
		'alignment_score',
		'similarity_score',
		'ai_feedback'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function syllabus_section()
	{
		return $this->belongsTo(SyllabusSection::class, 'section_id');
	}

	public function syllabus_content_mappings()
	{
		return $this->hasMany(SyllabusContentMapping::class, 'content_id');
	}
}
