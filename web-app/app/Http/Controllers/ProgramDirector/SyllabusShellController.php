<?php

namespace App\Http\Controllers\ProgramDirector;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PerformanceIndicator;
use App\Models\ProgramLearningOutcome;
use App\Models\Status;
use App\Models\Syllabus;
use App\Models\SyllabusAssignment;
use App\Models\SyllabusContent;
use App\Models\SyllabusPiTarget;
use App\Models\SyllabusPloTarget;
use App\Models\SyllabusSection;
use App\Models\SyllabusTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SyllabusShellController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $courses = Course::where('program_id', $user->program_id)
            ->orderBy('course_name')
            ->get();

        $templates = SyllabusTemplate::where('is_active', true)
            ->orderBy('template_name')
            ->get();

        $lecturers = User::where('department_id', $user->department_id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->whereHas('roles', function ($q) {
                $q->where('role_name', RoleName::LECTURER->value);
            })
            ->orderBy('full_name')
            ->get();

        $plos = ProgramLearningOutcome::where('program_id', $user->program_id)
            ->orderBy('code')
            ->get();

        $pis = PerformanceIndicator::whereHas('programLearningOutcome', function ($q) use ($user) {
            $q->where('program_id', $user->program_id);
        })
            ->orderBy('code')
            ->get();

        return view(
            'program_director.syllabus_shells.create',
            compact(
                'courses',
                'templates',
                'lecturers',
                'plos',
                'pis'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'template_id' => 'required|exists:syllabus_templates,id',
            'assigned_to' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:20',

            'plo_ids' => 'required|array|min:1',
            'plo_ids.*' => 'exists:program_learning_outcomes,id',

            'pi_ids' => 'nullable|array',
            'pi_ids.*' => 'exists:performance_indicators,id',

            'planning_note' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {

            $assignedStatus = Status::where('status_name', 'Assigned')
                ->firstOrFail();

            $syllabus = Syllabus::create([
                'course_id' => $request->course_id,
                'template_id' => $request->template_id,
                'academic_year' => $request->academic_year,
                'created_by' => Auth::id(),
                'status_id' => $assignedStatus->id,
                'planning_note' => $request->planning_note,
                'due_date' => $request->due_date,
            ]);

            SyllabusAssignment::create([
                'syllabus_id' => $syllabus->id,
                'user_id' => $request->assigned_to,
                'assignment_role' => 'PRIMARY_AUTHOR',
                'assigned_by' => Auth::id(),
                'assigned_at' => now(),
            ]);

            $sections = SyllabusSection::where('template_id', $request->template_id)
                ->orderBy('display_order')
                ->get();

            foreach ($sections as $section) {

                SyllabusContent::create([
                    'syllabus_id' => $syllabus->id,
                    'section_id' => $section->id,
                    'content_html' => '',
                    'content_raw' => null,
                ]);
            }

            foreach ($request->plo_ids as $ploId) {

                SyllabusPloTarget::create([
                    'syllabus_id' => $syllabus->id,
                    'plo_id' => $ploId,
                ]);
            }

            foreach ($request->pi_ids ?? [] as $piId) {

                SyllabusPiTarget::create([
                    'syllabus_id' => $syllabus->id,
                    'pi_id' => $piId,
                ]);
            }
        });

        return redirect()
            ->route('program-director.syllabus-shells.create')
            ->with(
                'success',
                'Tạo syllabus shell và phân công giảng viên thành công.'
            );
    }
}
