<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyllabusHistory
 * 
 * @property int $id
 * @property int $syllabus_id
 * @property int|null $changed_by
 * @property string|null $change_description
 * @property string|null $old_content
 * @property string|null $new_content
 * @property string|null $ai_summary
 * @property Carbon|null $created_at
 * 
 * @property Syllabus $syllabus
 * @property User|null $user
 *
 * @package App\Models
 */
class SyllabusHistory extends Model
{
	protected $table = 'syllabus_history';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'changed_by' => 'int'
	];

	protected $fillable = [
		'syllabus_id',
		'changed_by',
		'change_description',
		'old_content',
		'new_content',
		'ai_summary'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'changed_by');
	}
}
