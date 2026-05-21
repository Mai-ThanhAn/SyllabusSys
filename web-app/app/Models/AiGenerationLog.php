<?php

namespace App\Models;

use App\Models\Base\AiGenerationLog as BaseAiGenerationLog;

class AiGenerationLog extends BaseAiGenerationLog
{
    protected $fillable = [
        'syllabus_id',
        'section_code',
        'generation_type',
        'input_context',
        'generated_output',
        'verification_result',
        'status',
        'model_name',
    ];

    protected $casts = [
        'syllabus_id' => 'int',
        'input_context' => 'array',
        'generated_output' => 'array',
        'verification_result' => 'array',
    ];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class, 'syllabus_id');
    }
}
