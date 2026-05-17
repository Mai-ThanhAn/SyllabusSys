<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusContentMapping
 * 
 * @property int $id
 * @property int|null $content_id
 * @property int|null $outcome_id
 * @property string|null $mapping_type
 * @property Carbon|null $created_at
 * 
 * @property SyllabusContent|null $syllabus_content
 * @property LearningOutcome|null $learning_outcome
 *
 * @package App\Models
 */
class SyllabusContentMapping extends Model
{
	protected $table = 'syllabus_content_mappings';
	public $timestamps = false;

	protected $casts = [
		'content_id' => 'int',
		'outcome_id' => 'int'
	];

	protected $fillable = [
		'content_id',
		'outcome_id',
		'mapping_type'
	];

	public function syllabus_content()
	{
		return $this->belongsTo(SyllabusContent::class, 'content_id');
	}

	public function learning_outcome()
	{
		return $this->belongsTo(LearningOutcome::class, 'outcome_id');
	}
}
