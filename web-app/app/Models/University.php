<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * 
 * @property Collection|Department[] $departments
 *
 * @package App\Models
 */
class University extends Model
{
	protected $table = 'universities';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'address'
	];

	public function departments()
	{
		return $this->hasMany(Department::class);
	}
}
