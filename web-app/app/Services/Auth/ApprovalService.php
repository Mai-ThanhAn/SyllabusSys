<?php

namespace App\Services\Auth;

use App\Enums\ApprovalStatus;
use App\Enums\RoleName;
use App\Models\ApprovalRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    public function approve(ApprovalRequest $request, User $approver): void
    {
        if (!$this->canApprove($approver, $request->requested_role)) {
            throw new \Exception('Bạn không có quyền duyệt vai trò này.');
        }

        DB::transaction(function () use ($request, $approver) {
            $role = Role::where('role_name', $request->requested_role)->firstOrFail();

            $request->user->update([
                'is_approved' => true,
                'is_active' => true,
            ]);

            $request->user->roles()->syncWithoutDetaching([
                $role->id => [
                    'start_date' => now(),
                    'end_date' => null,
                ]
            ]);

            $request->update([
                'status' => ApprovalStatus::APPROVED->value,
                'approved_by' => $approver->id,
                'approved_at' => now(),
            ]);
        });
    }

    public function reject(ApprovalRequest $request, User $approver, ?string $reason = null): void
    {
        if (!$this->canApprove($approver, $request->requested_role)) {
            throw new \Exception('Bạn không có quyền từ chối vai trò này.');
        }

        $request->update([
            'status' => ApprovalStatus::REJECTED->value,
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'rejected_reason' => $reason,
        ]);
    }

    public function canApprove(User $approver, string $requestedRole): bool
    {
        $approverRole = $approver->getPrimaryRole();

        return match ($approverRole) {
            RoleName::SUPERADMIN->value => in_array($requestedRole, [
                RoleName::UNIVERSITY_ADMIN->value,
            ]),

            RoleName::UNIVERSITY_ADMIN->value => in_array($requestedRole, [
                RoleName::DEPARTMENT_ADMIN->value,
            ]),

            RoleName::DEPARTMENT_ADMIN->value => in_array($requestedRole, [
                RoleName::PROGRAM_DIRECTOR->value,
                RoleName::LECTURER->value,
            ]),

            default => false,
        };
    }
}
