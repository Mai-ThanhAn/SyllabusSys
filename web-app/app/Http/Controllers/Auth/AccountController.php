<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;

use App\Services\Auth\GoogleAuthService;
use App\Services\Auth\RoleRedirectService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    public function __construct(
        protected GoogleAuthService $googleAuthService,
        protected RoleRedirectService $roleRedirectService
    ) {}

    public function login()
    {
        return view('account.login');
    }

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();

            $user = $this->googleAuthService
                ->handleGoogleLogin($googleUser);

            // User chưa tồn tại
            if (!$user) {

                session([
                    'GoogleEmail' => $googleUser->email,
                    'GoogleName' => $googleUser->name,
                    'GoogleAvatar' => $googleUser->avatar,
                    'GoogleId' => $googleUser->id
                ]);

                return redirect()
                    ->route('account.chooseRole');
            }

            $roleName = $this->googleAuthService
                ->login($user);

            return $this->roleRedirectService
                ->redirect($roleName);
        } catch (\Exception $ex) {

            return redirect()
                ->route('account.login')
                ->with('error', $ex->getMessage());
        }
    }

    public function registerLecturer()
    {
        if (!session()->has('GoogleEmail')) {

            return redirect()
                ->route('account.login')
                ->with('error', 'Phiên đăng ký đã hết hạn.');
        }

        $universities = University::all();

        return view('account.register_advisor', [
            'email' => session('GoogleEmail'),
            'fullName' => session('GoogleName'),
            'universities' => $universities
        ]);
    }

    public function storeLecturer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',

            'full_name' => 'required|string|max:255',

            'university_id' => 'required|integer|exists:universities,id',

            'department_id' => 'required|integer|exists:departments,id',

            'requested_role' => 'required|string'
        ]);

        if (User::where('email', $request->email)->exists()) {

            return redirect()
                ->route('account.login')
                ->with('error', 'Email đã tồn tại.');
        }

        try {

            $this->googleAuthService
                ->registerLecturer([

                    'email' => $request->email,

                    'full_name' => $request->full_name,

                    'requested_role' => $request->requested_role,

                    'university_id' => $request->university_id,

                    'department_id' => $request->department_id,

                    'note' => $request->note,

                    'google_id' => session('GoogleId'),

                    'avatar_url' => session('GoogleAvatar')
                ]);

            session()->forget([
                'GoogleEmail',
                'GoogleName',
                'GoogleAvatar',
                'GoogleId'
            ]);

            return redirect()
                ->route('account.login')
                ->with(
                    'success',
                    'Đăng ký thành công. Vui lòng chờ Admin duyệt.'
                );
        } catch (\Exception $ex) {

            return back()
                ->withInput()
                ->with('error', $ex->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }

    public function chooseRole()
    {
        if (!session()->has('GoogleEmail')) {
            return redirect()
                ->route('account.login')
                ->with('error', 'Phiên đăng ký đã hết hạn.');
        }

        return view('account.choose_role', [
            'email' => session('GoogleEmail'),
            'fullName' => session('GoogleName')
        ]);
    }
}
