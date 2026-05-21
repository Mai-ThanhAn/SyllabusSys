<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Danh sách viện/khoa
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $departments = Department::with([
            'university',
            'head',
        ])
            ->orderBy('id')
            ->get();

        return view(
            'university_admin.departments.index',
            compact('departments')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form tạo viện/khoa
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $universities = University::orderBy('id')->get();

        return view(
            'university_admin.departments.create',
            compact('universities')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Lưu viện/khoa
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id',
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'university_id' => $request->university_id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('university-admin.departments.index')
            ->with('success', 'Đã tạo viện/khoa.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form sửa viện/khoa
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        $universities = University::orderBy('id')->get();

        return view(
            'university_admin.departments.edit',
            compact('department', 'universities')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cập nhật viện/khoa
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'department_name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id',
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'university_id' => $request->university_id,
        ]);

        return redirect()
            ->route('university-admin.departments.index')
            ->with('success', 'Đã cập nhật viện/khoa.');
    }

    /*
    |--------------------------------------------------------------------------
    | Xóa viện/khoa
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Department::findOrFail($id)->delete();

        return redirect()
            ->route('university-admin.departments.index')
            ->with('success', 'Đã xóa viện/khoa.');
    }

    /*
    |--------------------------------------------------------------------------
    | Màn hình bổ nhiệm trưởng khoa
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $department = Department::with([
            'university',
            'head',
        ])->findOrFail($id);

        $users = User::with('roles')
            ->where('is_active', true)
            ->where('is_approved', true)
            ->orderBy('full_name')
            ->get();

        return view(
            'university_admin.departments.show',
            compact('department', 'users')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Bổ nhiệm trưởng khoa
    |--------------------------------------------------------------------------
    */
    public function assignHead(Request $request, $departmentId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $department = Department::findOrFail($departmentId);

        $user = User::findOrFail($request->user_id);

        /*
        |--------------------------------------------------------------------------
        | Update department head
        |--------------------------------------------------------------------------
        */
        $department->update([
            'head_user_id' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Gán role Department_Admin
        |--------------------------------------------------------------------------
        */
        $role = Role::where(
            'role_name',
            'Department_Admin'
        )->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([
                $role->id => [
                    'start_date' => now(),
                    'end_date' => null,
                ],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Gán user thuộc department
        |--------------------------------------------------------------------------
        */
        $user->update([
            'department_id' => $department->id,
        ]);

        return redirect()
            ->route(
                'university-admin.departments.show',
                $department->id
            )
            ->with(
                'success',
                'Đã bổ nhiệm trưởng khoa.'
            );
    }
}
