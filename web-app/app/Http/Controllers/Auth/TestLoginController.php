<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Sai email hoặc mật khẩu.');
        }

        $request->session()->regenerate();

        $user = User::with('roles')->find(Auth::id());

        $role = $user?->roles->first()?->role_name;

        // dd([
        //     'user' => $user?->email,
        //     'roles' => $user?->roles->pluck('role_name')->toArray(),
        //     'selected_role' => $role,
        // ]);

        return match ($role) {
            'Lecturer' => redirect()->route('lecturer.dashboard'),
            'Program_Director' => redirect()->route('program-director.syllabus-shells.create'),
            'Department_Admin' => redirect()->route('program-director.syllabus-shells.index'),
            'University_Admin' => redirect('/admin/courses'),
            'Superadmin' => redirect('/admin/courses'),
            default => redirect('/')->with('error', 'Tài khoản chưa có quyền phù hợp.'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
