<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusApproval;
use App\Models\Base\SyllabusVersion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 *
 * @property int $id
 * @property string|null $status_name
 * @property string|null $description
 *
 * @property Collection|SyllabusApproval[] $syllabus_approvals
 * @property Collection|SyllabusVersion[] $syllabus_versions
 *
 * @package App\Models\Base\Base
 */
class Status extends Model
{
	protected $table = 'statuses';
	public $timestamps = false;

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class);
	}

	public function syllabus_versions()
	{
		return $this->hasMany(SyllabusVersion::class);
	}
}
