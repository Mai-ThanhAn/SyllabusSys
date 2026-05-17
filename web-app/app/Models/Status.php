<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 *
 * @package App\Models
 */
class Status extends Model
{
	protected $table = 'statuses';
	public $timestamps = false;

	protected $fillable = [
		'status_name',
		'description'
	];

	public function syllabus_approvals()
	{
		return $this->hasMany(SyllabusApproval::class);
	}
}
