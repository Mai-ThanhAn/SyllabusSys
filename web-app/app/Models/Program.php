<?php

namespace App\Models;

use App\Models\Base\Program as BaseProgram;

class Program extends BaseProgram
{
    protected $fillable = [
        'name',
        'code',
        'department_id',
        'director_user_id',
    ];

    public function director()
    {
        return $this->belongsTo(User::class, 'director_user_id');
    }
}
