<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 * 
 * @property int $id
 * @property int $user_id
 * @property string $student_code
 * @property int $department_id
 * @property string $academic_class
 * @property Carbon|null $created_at
 * 
 * @property User $user
 * @property Department $department
 *
 * @package App\Models
 */
class Student extends Model
{
	protected $table = 'students';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'student_code',
		'department_id',
		'academic_class'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}
