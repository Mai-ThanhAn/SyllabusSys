<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Syllabus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusAssignment
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int $user_id
 * @property string $assignment_role
 * @property int|null $assigned_by
 * @property Carbon|null $assigned_at
 *
 * @property Syllabus $syllabus
 * @property User|null $user
 *
 * @package App\Models\Base\Base
 */
class SyllabusAssignment extends Model
{
	protected $table = 'syllabus_assignments';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'user_id' => 'int',
		'assigned_by' => 'int',
		'assigned_at' => 'datetime'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'assigned_by');
	}
}
