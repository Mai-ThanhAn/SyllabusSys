<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('program')
            ->whereHas('program', function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            })
            ->orderBy('id')
            ->get();

        return view('department.courses.index', compact('courses'));
    }

    public function create()
    {
        $programs = Program::where('department_id', Auth::user()->department_id)
            ->orderBy('name')
            ->get();

        return view('department.courses.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:50',
            'course_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'program_id' => 'required|exists:programs,id',
        ]);

        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($request->program_id);

        Course::create([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
            'credits' => $request->credits,
            'program_id' => $program->id,
        ]);

        return redirect()
            ->route('department.courses.index')
            ->with('success', 'Đã thêm môn học.');
    }

    public function edit($id)
    {
        $course = Course::whereHas('program', function ($q) {
            $q->where('department_id', Auth::user()->department_id);
        })
            ->findOrFail($id);

        $programs = Program::where('department_id', Auth::user()->department_id)
            ->orderBy('name')
            ->get();

        return view('department.courses.edit', compact('course', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::whereHas('program', function ($q) {
            $q->where('department_id', Auth::user()->department_id);
        })
            ->findOrFail($id);

        $request->validate([
            'course_code' => 'required|string|max:50',
            'course_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'program_id' => 'required|exists:programs,id',
        ]);

        $program = Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($request->program_id);

        $course->update([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
            'credits' => $request->credits,
            'program_id' => $program->id,
        ]);

        return redirect()
            ->route('department.courses.index')
            ->with('success', 'Đã cập nhật môn học.');
    }

    public function destroy($id)
    {
        $course = Course::whereHas('program', function ($q) {
            $q->where('department_id', Auth::user()->department_id);
        })
            ->findOrFail($id);

        $course->delete();

        return back()->with('success', 'Đã xóa môn học.');
    }
}
