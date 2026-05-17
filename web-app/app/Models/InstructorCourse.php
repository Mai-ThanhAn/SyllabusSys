<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InstructorCourse
 * 
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int|null $assigned_by
 * @property Carbon|null $created_at
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
		'user_id' => 'int',
		'course_id' => 'int',
		'assigned_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'course_id',
		'assigned_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
