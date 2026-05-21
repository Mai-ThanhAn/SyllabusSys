<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepartmentMemberController extends Controller
{
    public function index()
    {
        $members = User::with('roles')
            ->where('department_id', Auth::user()->department_id)
            ->orderBy('full_name')
            ->get();

        return view('department.members.index', compact('members'));
    }

    public function assignProgramDirector($userId)
    {
        $user = User::where('department_id', Auth::user()->department_id)
            ->findOrFail($userId);

        $role = Role::where('role_name', 'Program_Director')
            ->firstOrFail();

        $user->roles()->syncWithoutDetaching([
            $role->id => [
                'start_date' => now(),
                'end_date' => null,
            ],
        ]);

        return back()->with('success', 'Đã bổ nhiệm Program Director.');
    }
}
