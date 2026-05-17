<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id
 * @property string|null $role_name
 *
 * @property Collection|User[] $users
 *
 * @package App\Models\Base\Base
 */
class Role extends Model
{
	protected $table = 'roles';
	public $timestamps = false;

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_roles')
					->withPivot('start_date', 'end_date');
	}
}
