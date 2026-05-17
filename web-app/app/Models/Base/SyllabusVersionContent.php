<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusSection;
use App\Models\Base\SyllabusVersion;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusVersionContent
 *
 * @property int $id
 * @property int $version_id
 * @property int $section_id
 * @property string|null $content_html
 *
 * @property SyllabusVersion $syllabus_version
 * @property SyllabusSection $syllabus_section
 *
 * @package App\Models\Base\Base
 */
class SyllabusVersionContent extends Model
{
	protected $table = 'syllabus_version_contents';
	public $timestamps = false;

	protected $casts = [
		'version_id' => 'int',
		'section_id' => 'int'
	];

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}

	public function syllabus_section()
	{
		return $this->belongsTo(SyllabusSection::class, 'section_id');
	}
}
