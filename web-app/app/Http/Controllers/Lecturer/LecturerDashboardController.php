<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\SyllabusAssignment;
use Illuminate\Support\Facades\Auth;

class LecturerDashboardController extends Controller
{
    public function index()
    {
        $assignments = SyllabusAssignment::with([
            'syllabus.course.program',
            'syllabus.status',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('lecturer.dashboard', compact('assignments'));
    }
}
