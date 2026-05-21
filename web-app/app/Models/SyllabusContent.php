<?php

namespace App\Models;

use App\Models\Base\SyllabusContent as BaseSyllabusContent;

class SyllabusContent extends BaseSyllabusContent
{
    protected $fillable = [
        'syllabus_id',
        'section_id',
        'content_html',
        'content_raw',
    ];

    protected $casts = [
        'syllabus_id' => 'int',
        'section_id' => 'int',
    ];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }

    public function section()
    {
        return $this->belongsTo(SyllabusSection::class, 'section_id');
    }
}
