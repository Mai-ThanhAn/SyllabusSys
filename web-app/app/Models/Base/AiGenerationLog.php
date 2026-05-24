<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AiGenerationLog
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property string|null $section_code
 * @property string|null $input_context
 * @property string|null $retrieved_examples
 * @property string|null $generated_output
 * @property string|null $model_name
 * @property Carbon|null $created_at
 * @property string|null $generation_type
 * @property string|null $verification_result
 * @property string|null $status
 *
 * @property Syllabus|null $syllabus
 *
 * @package App\Models\Base\Base
 */
class AiGenerationLog extends Model
{
	protected $table = 'ai_generation_logs';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'input_context' => 'binary',
		'retrieved_examples' => 'binary',
		'generated_output' => 'binary',
		'verification_result' => 'binary'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}
}
