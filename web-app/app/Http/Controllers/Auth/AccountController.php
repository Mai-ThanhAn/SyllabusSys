<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    // --- LOGIN PLAIN VIEW ---
    public function login()
    {
        return view('account.login');
    }

    // --- ĐIỀU HƯỚNG SANG GOOGLE ---
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // --- GOOGLE CALLBACK ---
    public function googleCallback()
    {
        try {
            // Socialite tự động đổi 'code' lấy Token và parse Payload cho bạn
            $googleUser = Socialite::driver('google')->user();

            // 1. Chỉ cho phép email trường TDMU
            if (!str_ends_with($googleUser->email, 'tdmu.edu.vn')) {
                return redirect()->route('account.login')
                    ->with('error', 'Chỉ chấp nhận email trường TDMU.');
            }

            // 2. Kiểm tra user tồn tại chưa
            $user = User::where('email', $googleUser->email)->first();

            // =========================
            // USER CHƯA TỒN TẠI → Chọn Role
            // =========================
            if (!$user) {
                // Giữ lại data dạng TempData giống C#
                session()->flash('GoogleEmail', $googleUser->email);
                session()->flash('GoogleName', $googleUser->name);

                return redirect()->route('account.chooseRole');
            }

            // =========================
            // CHƯA ĐƯỢC DUYỆT
            // =========================
            if ($user->is_approved == false) {
                return redirect()->route('account.login')
                    ->with('error', 'Tài khoản đang chờ phê duyệt.');
            }

            // =========================
            // BỊ KHÓA
            // =========================
            if ($user->is_active == false) {
                return redirect()->route('account.login')
                    ->with('error', 'Tài khoản đã bị khóa.');
            }

            // =========================
            // LOGIN & SET SESSION
            // =========================
            $this->setUserSession($user);

            // Cập nhật thời gian đăng nhập
            $user->update([
                'last_login_at' => Carbon::now()
            ]);

            // =========================
            // ĐIỀU HƯỚNG THEO ROLE
            // =========================
            // return $this->redirectByRole($user);

        } catch (\Exception $ex) {
            return redirect()->route('account.login')
                ->with('error', 'Lỗi xác thực: ' . $ex->getMessage());
        }
    }

    // --- REGISTER ADVISOR ---
    public function registerAdvisor()
    {
        $email = session()->get('GoogleEmail');
        $fullName = session()->get('GoogleName');
        session()->keep(['GoogleEmail', 'GoogleName']);

        return view('account.register_advisor', compact('email', 'fullName', 'departments', 'faculties'));
    }

    public function storeAdvisor(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'full_name' => 'required',
            'requested_role' => 'required',
            'department_id' => 'required',
            'faculty_id' => 'required',
        ]);

        // Check trùng email
        if (User::where('email', $request->email)->exists()) {
            return redirect()->route('account.login')->with('error', 'Email đã tồn tại.');
        }

        // Tạo User trạng thái chờ duyệt
        $user = User::create([
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role' => $request->requested_role,
            'is_approved' => false,
            'is_active' => false,
            'avatar_url' => 'default.jpg'
        ]);

        // Tạo Request phê duyệt
        // ApprovalRequest::create([
        //     'user_id' => $user->id,
        //     'requested_role' => $request->requested_role,
        //     'department_id' => $request->department_id,
        //     'faculty_id' => $request->faculty_id,
        //     'note' => $request->note,
        //     'status' => 'Pending'
        // ]);

        return redirect()->route('account.login')
            ->with('success', 'Đăng ký thành công. Vui lòng chờ Admin duyệt.');
    }

    // --- LOGOUT ---
    public function logout()
    {
        session()->flush(); // Xóa sạch session
        return redirect()->route('home');
    }

    // =================================--------------------------------
    // PRIVATE METHODS
    // =================================--------------------------------

    private function setUserSession($user)
    {
        session([
            'UserID'   => $user->id,
            'FullName' => $user->full_name,
            'Role'     => $user->role
        ]);
    }

    // private function redirectByRole($user)
    // {
    //     switch ($user->role) {
    //         case 'Student':
    //             $student = Student::where('user_id', $user->id)->first();

    //             if (!$student) {
    //                 return redirect()->route('student.onboarding.step1');
    //             }

    //             session(['StudentID' => $student->id]);
    //             return redirect()->route('student.home');

    //         case 'Advisor':
    //             return redirect()->route('advisor.home');

    //         case 'Director':
    //             return redirect()->route('director.home');

    //         case 'Admin':
    //             return redirect()->route('admin.dashboard');

    //         default:
    //             return redirect()->route('account.login');
    //     }
    // }
}
