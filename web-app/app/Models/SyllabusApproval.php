<?php

namespace App\Models;

use App\Models\Base\SyllabusApproval as BaseSyllabusApproval;

class SyllabusApproval extends BaseSyllabusApproval
{
    public function version()
    {
        return $this->belongsTo(SyllabusVersion::class, 'version_id');
    }
}
