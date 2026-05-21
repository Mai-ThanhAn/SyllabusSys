<?php

namespace App\Models;

use App\Models\Base\ProgramLearningOutcome as BaseProgramLearningOutcome;

class ProgramLearningOutcome extends BaseProgramLearningOutcome
{
    protected $fillable = [
    'program_id',
    'code',
    'description',
];
}
