<?php

namespace App\Services\Auth;

use App\Enums\RoleName;

class RoleRedirectService
{
    public function redirect(string $roleName)
    {
        return match ($roleName) {

            RoleName::SUPERADMIN->value,
            RoleName::UNIVERSITY_ADMIN->value
                => redirect()->route('admin.dashboard'),

            RoleName::PROGRAM_DIRECTOR->value,
            RoleName::LECTURER->value
                => redirect()->route('lecturer.dashboard'),

            default
                => redirect()->route('account.chooseRole')
        };
    }
}
