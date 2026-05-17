<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $email
 * @property string $full_name
 * @property string|null $google_id
 * @property string|null $avatar_url
 * @property bool|null $is_approved
 * @property bool|null $is_active
 * @property Carbon|null $last_login_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|SyllabusHistory[] $syllabus_histories
 * @property Collection|InstructorCourse[] $instructor_courses
 * @property Collection|SyllabusApproval[] $syllabus_approvals
 * @property Collection|Role[] $roles
 * @property Collection|SyllabusVersion[] $syllabus_versions
 * @property Collection|Syllabus[] $syllabi
 * @property Collection|Lecture[] $lectures
 * @property Collection|ApprovalRequest[] $approval_requests
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'is_approved' => 'bool',
		'is_active' => 'bool',
		'last_login_at' => 'datetime'
	];

	protected $fillable = [
		'email',
		'full_name',
		'google_id',
		'avatar_url',
		'is_approved',
		'is_active',
		'last_login_at'
	];

	public function syllabus_histories()
	{
		return $this->hasMany(SyllabusHistory::class, 'changed_by');
	}

	public function instructor_courses()
	{
		return $this->hasMany(InstructorCourse::class);
	}

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class, 'approved_by');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'user_roles')
					->withPivot('start_date', 'end_date');
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class, 'created_by');
	}

	public function syllabi()
	{
		return $this->hasMany(Syllabus::class, 'assigned_to');
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
