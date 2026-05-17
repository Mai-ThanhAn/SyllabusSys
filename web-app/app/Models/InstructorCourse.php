<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InstructorCourse
 * 
 * @property int $id
 * @property int $lecturer_id
 * @property int $course_id
 * @property string|null $role
 * 
 * @property User $user
 * @property Course $course
 *
 * @package App\Models
 */
class InstructorCourse extends Model
{
	protected $table = 'instructor_courses';
	public $timestamps = false;

	protected $casts = [
		'lecturer_id' => 'int',
		'course_id' => 'int'
	];

	protected $fillable = [
		'lecturer_id',
		'course_id',
		'role'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'lecturer_id');
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
