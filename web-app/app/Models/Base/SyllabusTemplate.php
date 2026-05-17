<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusSection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusTemplate
 *
 * @property int $id
 * @property string $template_name
 * @property string|null $description
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|SyllabusSection[] $syllabus_sections
 * @property Collection|Syllabus[] $syllabi
 *
 * @package App\Models\Base\Base
 */
class SyllabusTemplate extends Model
{
	protected $table = 'syllabus_templates';

	protected $casts = [
		'is_active' => 'bool'
	];

	public function syllabus_sections()
	{
		return $this->hasMany(SyllabusSection::class, 'template_id');
	}

	public function syllabi()
	{
		return $this->hasMany(Syllabus::class, 'template_id');
	}
}
