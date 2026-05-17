<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Department;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApprovalRequest
 *
 * @property int $id
 * @property int $user_id
 * @property string $requested_role
 * @property int|null $department_id
 * @property string|null $note
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $approved_by
 * @property Carbon|null $approved_at
 * @property string|null $rejected_reason
 *
 * @property User|null $user
 * @property Department|null $department
 *
 * @package App\Models\Base\Base
 */
class ApprovalRequest extends Model
{
	protected $table = 'approval_requests';

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int',
		'approved_by' => 'int',
		'approved_at' => 'datetime'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'approved_by');
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}
