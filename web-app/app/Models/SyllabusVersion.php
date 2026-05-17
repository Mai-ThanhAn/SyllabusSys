<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersion
 * 
 * @property int $id
 * @property int $syllabus_id
 * @property int $version_number
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * 
 * @property Syllabus $syllabus
 * @property User|null $user
 * @property Collection|SyllabusApproval[] $syllabus_approvals
 * @property Collection|SyllabusVersionContent[] $syllabus_version_contents
 *
 * @package App\Models
 */
class SyllabusVersion extends Model
{
	protected $table = 'syllabus_versions';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'version_number' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'syllabus_id',
		'version_number',
		'created_by'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class, 'version_id');
	}

	public function syllabus_version_contents()
	{
		return $this->hasMany(SyllabusVersionContent::class, 'version_id');
	}
}
