<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * 
 * @property int $user_id
 * @property int $role_id
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * 
 * @property User $user
 * @property Role $role
 *
 * @package App\Models
 */
class UserRole extends Model
{
	protected $table = 'user_roles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'role_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	protected $fillable = [
		'start_date',
		'end_date'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
