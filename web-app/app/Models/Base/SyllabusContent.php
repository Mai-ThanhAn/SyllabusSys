<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusContentMapping;
use App\Models\Base\SyllabusSection;
use App\Models\Base\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SyllabusContent
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property int|null $section_id
 * @property string|null $content_html
 * @property string|null $content_raw
 * @property float|null $alignment_score
 * @property float|null $similarity_score
 * @property string|null $ai_feedback
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $is_deleted
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Syllabus|null $syllabus
 * @property SyllabusSection|null $syllabus_section
 * @property User|null $user
 * @property Collection|SyllabusContentMapping[] $syllabus_content_mappings
 *
 * @package App\Models\Base\Base
 */
class SyllabusContent extends Model
{
	use SoftDeletes;
	protected $table = 'syllabus_contents';

	protected $casts = [
		'syllabus_id' => 'int',
		'section_id' => 'int',
		'content_raw' => 'binary',
		'alignment_score' => 'float',
		'similarity_score' => 'float',
		'is_deleted' => 'bool',
		'deleted_by' => 'int'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function syllabus_section()
	{
		return $this->belongsTo(SyllabusSection::class, 'section_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'deleted_by');
	}

	public function syllabus_content_mappings()
	{
		return $this->hasMany(SyllabusContentMapping::class, 'content_id');
	}
}
