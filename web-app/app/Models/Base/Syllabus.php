<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\SyllabusContent;
use App\Models\Base\SyllabusHistory;
use App\Models\Base\SyllabusOutcome;
use App\Models\Base\SyllabusTemplate;
use App\Models\Base\SyllabusVersion;
use App\Models\Base\User;
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
 * @property Collection|SyllabusOutcome[] $syllabus_outcomes
 * @property Collection|SyllabusVersion[] $syllabus_versions
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
		'assigned_to' => 'int',
		'status_id' => 'int'
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

	public function syllabus_outcomes()
	{
		return $this->hasMany(SyllabusOutcome::class);
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class);
	}
}
