<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Department;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class University
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property string $code
 *
 * @property Collection|Department[] $departments
 *
 * @package App\Models\Base\Base
 */
class University extends Model
{
	protected $table = 'universities';
	public $timestamps = false;

	public function departments()
	{
		return $this->hasMany(Department::class);
	}
}
