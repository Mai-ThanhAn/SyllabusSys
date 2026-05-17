<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @package App\Models
 */
class RagKnowledgeBase extends Model
{
	protected $table = 'rag_knowledge_base';
	public $timestamps = false;

	protected $casts = [
		'cleos' => 'binary',
		'topics' => 'binary'
	];

	protected $fillable = [
		'course_name',
		'clo_text',
		'cleos',
		'topics'
	];
}
