<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusStyleProfile
 *
 * @property int $id
 * @property string $name
 * @property string|null $course_type
 * @property string|null $description
 * @property string|null $structure_rules
 * @property string|null $writing_style_rules
 * @property Carbon|null $created_at
 *
 * @package App\Models\Base\Base
 */
class SyllabusStyleProfile extends Model
{
	protected $table = 'syllabus_style_profiles';
	public $timestamps = false;

	protected $casts = [
		'structure_rules' => 'binary',
		'writing_style_rules' => 'binary'
	];
}
