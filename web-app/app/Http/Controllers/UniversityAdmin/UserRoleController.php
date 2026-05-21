<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('id')->get();
        $roles = Role::orderBy('role_name')->get();

        return view('university_admin.users.index', compact('users', 'roles'));
    }

    public function assignRole(Request $request, int $userId)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);

        $user->roles()->syncWithoutDetaching([
            $request->role_id => [
                'start_date' => now(),
                'end_date' => null,
            ],
        ]);

        return back()->with('success', 'Đã gán role cho tài khoản.');
    }
}
