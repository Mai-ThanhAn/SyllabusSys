<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('program')->latest()->get();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $programs = Program::all();

        return view('admin.courses.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20|unique:courses,course_code',
            'course_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'program_id' => 'required|exists:programs,id',
        ]);

        Course::create($request->only([
            'course_code',
            'course_name',
            'credits',
            'program_id',
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Thêm môn học thành công.');
    }

    public function edit(int $id)
    {
        $course = Course::findOrFail($id);
        $programs = Program::all();

        return view('admin.courses.edit', compact('course', 'programs'));
    }

    public function update(Request $request, int $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'program_id' => 'required|exists:programs,id',
        ]);

        $course->update($request->only([
            'course_code',
            'course_name',
            'credits',
            'program_id',
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Cập nhật môn học thành công.');
    }

    public function destroy(int $id)
    {
        Course::findOrFail($id)->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Xóa môn học thành công.');
    }
}
