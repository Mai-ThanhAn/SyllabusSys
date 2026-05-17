<?php

namespace App\Services\Auth;

use App\Enums\ApprovalStatus;
use App\Models\ApprovalRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as GoogleUser;
use Carbon\Carbon;

class GoogleAuthService
{
    public function handleGoogleLogin(GoogleUser $googleUser)
    {
        $this->validateSchoolEmail($googleUser->email);

        $user = User::with('roles')
            ->where('email', $googleUser->email)
            ->first();

        return $user;
    }

    public function validateSchoolEmail(string $email): void
    {
        if (!preg_match('/@tdmu\.edu\.vn$/', $email)) {
            throw new \Exception('Chỉ chấp nhận email trường TDMU.');
        }
    }

    public function login(User $user): string
    {
        if (!$user->is_approved) {
            throw new \Exception('Tài khoản đang chờ phê duyệt.');
        }

        if (!$user->is_active) {
            throw new \Exception('Tài khoản đã bị khóa.');
        }

        Auth::login($user);

        $role = $user->roles->first();

        $roleName = $role
            ? $role->role_name
            : 'Guest';

        session([
            'UserID' => $user->id,
            'FullName' => $user->full_name,
            'Role' => $roleName
        ]);

        $user->update([
            'last_login_at' => Carbon::now()
        ]);

        return $roleName;
    }

    public function registerLecturer(array $data): void
    {
        DB::transaction(function () use ($data) {

            $user = User::create([
                'email' => $data['email'],
                'full_name' => $data['full_name'],
                'google_id' => $data['google_id'] ?? null,
                'avatar_url' => $data['avatar_url'] ?? null,
                'is_approved' => false,
                'is_active' => true,
                'university_id' => $data['university_id'],
                'department_id' => $data['department_id'],
                'program_id' => $data['program_id'] ?? null,
            ]);

            ApprovalRequest::create([
                'user_id' => $user->id,
                'requested_role' => $data['requested_role'],
                'department_id' => $data['department_id'],
                'note' => $data['note'] ?? null,
                'status' => ApprovalStatus::PENDING->value
            ]);
        });
    }
}
