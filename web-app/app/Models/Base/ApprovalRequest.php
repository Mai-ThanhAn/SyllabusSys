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
 *
 * @property User $user
 * @property Department|null $department
 *
 * @package App\Models\Base\Base
 */
class ApprovalRequest extends Model
{
	protected $table = 'approval_requests';

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int'
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
