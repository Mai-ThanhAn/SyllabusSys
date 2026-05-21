<?php

namespace App\Models;

use App\Models\Base\SyllabusSection as BaseSyllabusSection;

class SyllabusSection extends BaseSyllabusSection
{
    protected $fillable = [
    'template_id',
    'title',
    'section_code',
    'display_order',
    'input_type',
    'is_required',
    'is_editable',
    'is_ai_generatable',
];
}
