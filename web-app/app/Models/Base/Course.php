<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\ApprovedSyllabusCorpu;
use App\Models\Base\InstructorCourse;
use App\Models\Base\Program;
use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusRagCorpu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property int $id
 * @property string $course_code
 * @property string $course_name
 * @property int $credits
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $program_id
 *
 * @property Program|null $program
 * @property Collection|InstructorCourse[] $instructor_courses
 * @property Collection|ApprovedSyllabusCorpu[] $approved_syllabus_corpus
 * @property Collection|Syllabus[] $syllabi
 * @property Collection|SyllabusRagCorpu[] $syllabus_rag_corpus
 *
 * @package App\Models\Base\Base
 */
class Course extends Model
{
	protected $table = 'courses';

	protected $casts = [
		'credits' => 'int',
		'program_id' => 'int'
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}

	public function instructor_courses()
	{
		return $this->hasMany(InstructorCourse::class);
	}

	public function approved_syllabus_corpus()
	{
		return $this->hasMany(ApprovedSyllabusCorpu::class);
	}

	public function syllabi()
	{
		return $this->hasMany(Syllabus::class);
	}

	public function syllabus_rag_corpus()
	{
		return $this->hasMany(SyllabusRagCorpu::class);
	}
}
