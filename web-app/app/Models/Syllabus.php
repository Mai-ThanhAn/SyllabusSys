<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property string|null $status
 * @property int|null $created_by
 * @property int|null $assigned_to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $status_id
 * 
 * @property Course $course
 * @property SyllabusTemplate $syllabus_template
 * @property User|null $user
 * @property Collection|SyllabusContent[] $syllabus_contents
 * @property Collection|SyllabusHistory[] $syllabus_histories
 * @property Collection|SyllabusVersion[] $syllabus_versions
 * @property Collection|SyllabusOutcome[] $syllabus_outcomes
 *
 * @package App\Models
 */
class Syllabus extends Model
{
	protected $table = 'syllabuses';

	protected $casts = [
		'course_id' => 'int',
		'template_id' => 'int',
		'created_by' => 'int',
		'assigned_to' => 'int',
		'status_id' => 'int'
	];

	protected $fillable = [
		'course_id',
		'template_id',
		'academic_year',
		'status',
		'created_by',
		'assigned_to',
		'status_id'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function syllabus_template()
	{
		return $this->belongsTo(SyllabusTemplate::class, 'template_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'assigned_to');
	}

	public function syllabus_contents()
	{
		return $this->hasMany(SyllabusContent::class);
	}

	public function syllabus_histories()
	{
		return $this->hasMany(SyllabusHistory::class);
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class);
	}

	public function syllabus_outcomes()
	{
		return $this->hasMany(SyllabusOutcome::class);
	}
}
