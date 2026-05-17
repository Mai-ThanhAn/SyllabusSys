<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\ApprovalRequest;
use App\Models\Base\InstructorCourse;
use App\Models\Base\Role;
use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusApproval;
use App\Models\Base\SyllabusContent;
use App\Models\Base\SyllabusHistory;
use App\Models\Base\SyllabusVersion;
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
 * @property int|null $university_id
 * @property int|null $department_id
 * @property int|null $program_id
 *
 * @property Collection|InstructorCourse[] $instructor_courses
 * @property Collection|SyllabusApproval[] $syllabus_approvals
 * @property Collection|SyllabusContent[] $syllabus_contents
 * @property Collection|SyllabusHistory[] $syllabus_histories
 * @property Collection|Role[] $roles
 * @property Collection|Syllabus[] $syllabi
 * @property Collection|ApprovalRequest[] $approval_requests
 * @property Collection|SyllabusVersion[] $syllabus_versions
 *
 * @package App\Models\Base\Base
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'is_approved' => 'bool',
		'is_active' => 'bool',
		'last_login_at' => 'datetime',
		'university_id' => 'int',
		'department_id' => 'int',
		'program_id' => 'int'
	];

	public function instructor_courses()
	{
		return $this->hasMany(InstructorCourse::class);
	}

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class, 'approved_by');
	}

	public function syllabus_contents()
	{
		return $this->hasMany(SyllabusContent::class, 'deleted_by');
	}

	public function syllabus_histories()
	{
		return $this->hasMany(SyllabusHistory::class, 'changed_by');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'user_roles')
					->withPivot('start_date', 'end_date');
	}

	public function syllabi()
	{
		return $this->hasMany(Syllabus::class, 'assigned_to');
	}

	public function approval_requests()
	{
		return $this->hasMany(ApprovalRequest::class, 'approved_by');
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class, 'created_by');
	}
}
