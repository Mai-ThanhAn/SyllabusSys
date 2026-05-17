<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\ApprovalRequest;
use App\Models\Base\Program;
use App\Models\Base\University;
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
 * @property Collection|ApprovalRequest[] $approval_requests
 *
 * @package App\Models\Base\Base
 */
class Department extends Model
{
	protected $table = 'departments';
	public $timestamps = false;

	protected $casts = [
		'university_id' => 'int'
	];

	public function university()
	{
		return $this->belongsTo(University::class);
	}

	public function programs()
	{
		return $this->hasMany(Program::class);
	}

	public function approval_requests()
	{
		return $this->hasMany(ApprovalRequest::class);
	}
}
