<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Course;
use App\Models\Base\Department;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Program
 *
 * @property int $id
 * @property int $department_id
 * @property string|null $code
 * @property string $name
 * @property Carbon|null $created_at
 *
 * @property Department $department
 * @property Collection|Course[] $courses
 *
 * @package App\Models\Base\Base
 */
class Program extends Model
{
	protected $table = 'programs';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function courses()
	{
		return $this->hasMany(Course::class);
	}
}
