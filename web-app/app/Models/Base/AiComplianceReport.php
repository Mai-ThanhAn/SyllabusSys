<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Base\Syllabus;
use App\Models\Base\SyllabusVersion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AiComplianceReport
 *
 * @property int $id
 * @property int|null $syllabus_id
 * @property int|null $version_id
 * @property array|null $report_json
 * @property float|null $overall_score
 * @property Carbon|null $created_at
 *
 * @property Syllabus|null $syllabus
 * @property SyllabusVersion|null $syllabus_version
 *
 * @package App\Models\Base\Base
 */
class AiComplianceReport extends Model
{
	protected $table = 'ai_compliance_reports';
	public $timestamps = false;

	protected $casts = [
		'syllabus_id' => 'int',
		'version_id' => 'int',
		'report_json' => 'json',
		'overall_score' => 'float'
	];

	public function syllabus()
	{
		return $this->belongsTo(Syllabus::class);
	}

	public function syllabus_version()
	{
		return $this->belongsTo(SyllabusVersion::class, 'version_id');
	}
}
