<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\Department;
use App\Models\Base\ProgramLearningOutcome;
use App\Models\Base\SyllabusRagCorpu;
use App\Models\Base\SyllabusTemplate;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Program
 *
 * @property int $id
 * @property int $department_id
 * @property string|null $code
 * @property string $name
 * @property Carbon|null $created_at
 * @property int|null $director_user_id
 *
 * @property Department $department
 * @property User|null $user
 * @property Collection|Course[] $courses
 * @property Collection|SyllabusTemplate[] $syllabus_templates
 * @property Collection|ProgramLearningOutcome[] $program_learning_outcomes
 * @property Collection|SyllabusRagCorpu[] $syllabus_rag_corpus
 *
 * @package App\Models\Base\Base
 */
class Program extends Model
{
	protected $table = 'programs';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int',
		'director_user_id' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'director_user_id');
	}

	public function courses()
	{
		return $this->hasMany(Course::class);
	}

	public function syllabus_templates()
	{
		return $this->hasMany(SyllabusTemplate::class);
	}

	public function program_learning_outcomes()
	{
		return $this->hasMany(ProgramLearningOutcome::class);
	}

	public function syllabus_rag_corpus()
	{
		return $this->hasMany(SyllabusRagCorpu::class);
	}
}
