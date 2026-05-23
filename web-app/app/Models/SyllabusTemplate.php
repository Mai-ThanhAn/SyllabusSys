<?php

namespace App\Models;

use App\Models\Base\SyllabusTemplate as BaseSyllabusTemplate;

class SyllabusTemplate extends BaseSyllabusTemplate
{
    protected $fillable = [
        'template_name',
        'description',
        'is_active',
        'department_id',
        'program_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function sections()
    {
        return $this->hasMany(\App\Models\SyllabusSection::class, 'template_id');
    }
}
