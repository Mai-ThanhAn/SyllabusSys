<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\InstructorCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorCourseController extends Controller
{
    public function create(int $courseId)
    {
        $course = Course::findOrFail($courseId);

        $lecturers = User::whereHas('roles', function ($q) {
            $q->where('role_name', RoleName::LECTURER->value);
        })
        ->where('is_approved', true)
        ->where('is_active', true)
        ->get();

        return view('admin.instructor_courses.create', compact('course', 'lecturers'));
    }

    public function store(Request $request, int $courseId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        InstructorCourse::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'course_id' => $courseId,
            ],
            [
                'assigned_by' => Auth::id(),
                'created_at' => now(),
            ]
        );

        return redirect()
            ->route('courses.index')
            ->with('success', 'Phân công giảng viên thành công.');
    }

    public function destroy(int $id)
    {
        InstructorCourse::findOrFail($id)->delete();

        return back()->with('success', 'Đã hủy phân công giảng viên.');
    }
}
