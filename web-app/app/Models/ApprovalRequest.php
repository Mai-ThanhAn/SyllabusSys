<?php

namespace App\Models;

use App\Models\Base\ApprovalRequest as BaseApprovalRequest;

class ApprovalRequest extends BaseApprovalRequest
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
