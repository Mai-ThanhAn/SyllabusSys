<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusApproval
 * 
 * @property int $id
 * @property int $version_id
 * @property int $approved_by
 * @property string|null $status
 * @property string|null $comment
 * @property Carbon|null $approved_at
 * @property int|null $status_id
 * 
 * @property SyllabusVersion $syllabus_version
 * @property User $user
 *
 * @package App\Models
 */
class SyllabusApproval extends Model
{
	protected $table = 'syllabus_approvals';
	public $timestamps = false;

	protected $casts = [
		'version_id' => 'int',
		'approved_by' => 'int',
		'approved_at' => 'datetime',
		'status_id' => 'int'
	];

	protected $fillable = [
		'version_id',
		'approved_by',
		'status',
		'comment',
		'approved_at',
		'status_id'
	];

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'approved_by');
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
