<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\InstructorCourse;
use Illuminate\Support\Facades\Auth;

class LecturerDashboardController extends Controller
{
    public function index()
    {
        $assignedCourses = InstructorCourse::with([
            'course.program',
            'course.syllabi'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('lecturer.dashboard', compact('assignedCourses'));
    }
}
