<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusVersion;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusHistory
 *
 * @property int $id
 * @property int $syllabus_id
 * @property int|null $changed_by
 * @property string|null $change_description
 * @property string|null $ai_summary
 * @property Carbon|null $created_at
 * @property string|null $action_type
 * @property int|null $from_version_id
 * @property int|null $to_version_id
 *
 * @property Syllabus $syllabus
 * @property User|null $user
 * @property SyllabusVersion|null $syllabus_version
 *
 * @package App\Models\Base\Base
 */
class SyllabusHistory extends Model
{
	protected $table = 'syllabus_history';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'changed_by' => 'int',
		'from_version_id' => 'int',
		'to_version_id' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'changed_by');
	}

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'to_version_id');
	}
}
