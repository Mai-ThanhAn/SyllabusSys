<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Status;
use App\Models\Base\SyllabusVersion;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusApproval
 *
 * @property int $id
 * @property int $version_id
 * @property int $approved_by
 * @property string|null $comment
 * @property Carbon|null $approved_at
 * @property int|null $status_id
 *
 * @property SyllabusVersion $syllabus_version
 * @property User $user
 * @property Status|null $status
 *
 * @package App\Models\Base\Base
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
