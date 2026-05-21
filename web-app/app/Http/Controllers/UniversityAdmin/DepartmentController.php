<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('head')->orderBy('id')->get();

        return view('university_admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('university_admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'department_code' => 'nullable|string|max:50',
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
        ]);

        return redirect()
            ->route('university-admin.departments.index')
            ->with('success', 'Đã tạo viện/khoa.');
    }

    public function edit(int $id)
    {
        $department = Department::findOrFail($id);

        return view('university_admin.departments.edit', compact('department'));
    }

    public function update(Request $request, int $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'department_name' => 'required|string|max:255',
            'department_code' => 'nullable|string|max:50',
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
        ]);

        return redirect()
            ->route('university-admin.departments.index')
            ->with('success', 'Đã cập nhật viện/khoa.');
    }

    public function destroy(int $id)
    {
        Department::findOrFail($id)->delete();

        return back()->with('success', 'Đã xóa viện/khoa.');
    }

    public function assignHead(Request $request, int $departmentId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $department = Department::findOrFail($departmentId);
        $user = User::findOrFail($request->user_id);

        $department->update([
            'head_user_id' => $user->id,
        ]);

        $role = Role::where('role_name', 'Department_Admin')->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([
                $role->id => [
                    'start_date' => now(),
                    'end_date' => null,
                ],
            ]);
        }

        $user->update([
            'department_id' => $department->id,
        ]);

        return back()->with('success', 'Đã bổ nhiệm viện trưởng/khoa trưởng.');
    }

    public function show(int $id)
    {
        $department = Department::with('head')->findOrFail($id);

        $users = User::where('is_active', true)
            ->where('is_approved', true)
            ->orderBy('full_name')
            ->get();

        return view('university_admin.departments.show', compact('department', 'users'));
    }
}
