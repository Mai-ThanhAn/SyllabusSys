<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $department_name
 * @property Carbon|null $created_at
 * @property int $university_id
 * 
 * @property University $university
 * @property Collection|Program[] $programs
 * @property Collection|Lecture[] $lectures
 * @property Collection|ApprovalRequest[] $approval_requests
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	public $timestamps = false;

	protected $casts = [
		'university_id' => 'int'
	];

	protected $fillable = [
		'department_name',
		'university_id'
	];

	public function university()
	{
		return $this->belongsTo(University::class);
	}

	public function programs()
	{
		return $this->hasMany(Program::class);
	}

	public function lectures()
	{
		return $this->hasMany(Lecture::class);
	}

	public function approval_requests()
	{
		return $this->hasMany(ApprovalRequest::class);
	}
}
