<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\SyllabusContent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusContentMapping
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $outcome_id
 * @property string|null $mapping_type
 * @property Carbon|null $created_at
 *
 * @property SyllabusContent|null $syllabus_content
 *
 * @package App\Models\Base\Base
 */
class SyllabusContentMapping extends Model
{
	protected $table = 'syllabus_content_mappings';
	public $timestamps = false;

	protected $casts = [
		'content_id' => 'int',
		'outcome_id' => 'int'
	];

	public function syllabus_content()
	{
		return $this->belongsTo(SyllabusContent::class, 'content_id');
	}
}
