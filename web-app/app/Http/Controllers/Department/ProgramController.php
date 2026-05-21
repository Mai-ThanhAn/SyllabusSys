<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with('director')
            ->where('department_id', Auth::user()->department_id)
            ->orderBy('id')
            ->get();

        return view('department.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('department.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        Program::create([
            'name' => $request->name,
            'code' => $request->code,
            'department_id' => Auth::user()->department_id,
        ]);

        return redirect()
            ->route('department.programs.index')
            ->with('success', 'Đã tạo chương trình đào tạo.');
    }

    public function edit($id)
    {
        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($id);

        return view('department.programs.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        $program->update([
            'name' => $request->program_name,
            'code' => $request->program_code,
        ]);

        return redirect()
            ->route('department.programs.index')
            ->with('success', 'Đã cập nhật chương trình đào tạo.');
    }

    public function destroy($id)
    {
        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($id);

        $program->delete();

        return back()->with('success', 'Đã xóa chương trình đào tạo.');
    }

    public function show($id)
    {
        $program = Program::with('director')
            ->where('department_id', Auth::user()->department_id)
            ->findOrFail($id);

        $users = User::with('roles')
            ->where('department_id', Auth::user()->department_id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->orderBy('full_name')
            ->get();

        return view('department.programs.show', compact('program', 'users'));
    }

    public function assignDirector(Request $request, $programId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($programId);

        $user = User::where('department_id', Auth::user()->department_id)
            ->findOrFail($request->user_id);

        $program->update([
            'director_user_id' => $user->id,
        ]);

        $role = Role::where('role_name', 'Program_Director')->firstOrFail();

        $user->roles()->syncWithoutDetaching([
            $role->id => [
                'start_date' => now(),
                'end_date' => null,
            ],
        ]);

        return back()->with('success', 'Đã bổ nhiệm giám đốc CTĐT.');
    }
}
