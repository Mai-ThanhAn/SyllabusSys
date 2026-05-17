<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RagKnowledgeBase
 *
 * @property int $id
 * @property string $course_name
 * @property string $clo_text
 * @property string $cleos
 * @property string|null $topics
 * @property Carbon|null $created_at
 *
 * @package App\Models\Base\Base
 */
class RagKnowledgeBase extends Model
{
	protected $table = 'rag_knowledge_base';
	public $timestamps = false;

	protected $casts = [
		'cleos' => 'binary',
		'topics' => 'binary'
	];
}
