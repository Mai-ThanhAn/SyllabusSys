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
    private function currentUser()
    {
        return Auth::user();
    }
    private function getCourseInMyProgram($courseId)
    {
        return Course::where('program_id', $this->currentUser()->program_id)
            ->findOrFail($courseId);
    }
    private function getTemplateInMyDepartment($templateId)
    {
        return SyllabusTemplate::where('department_id', $this->currentUser()->department_id)
            ->where('is_active', true)
            ->findOrFail($templateId);
    }
    private function getLecturerInMyDepartment($userId)
    {
        return User::where('department_id', $this->currentUser()->department_id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->whereHas('roles', function ($q) {
                $q->where('role_name', RoleName::LECTURER->value);
            })
            ->findOrFail($userId);
    }
    public function index()
    {
        $syllabuses = Syllabus::with([
            'course.program',
            'template',
            'status',
            'assignments.user',
        ])
            ->where('created_by', Auth::id())
            ->latest('id')
            ->get();

        return view(
            'program_director.syllabus_shells.index',
            compact('syllabuses')
        );
    }
    public function create()
    {
        $user = Auth::user();

        $courses = Course::where('program_id', $user->program_id)
            ->orderBy('course_name')
            ->get();

        $templates = SyllabusTemplate::where('is_active', true)
            ->where(
                'department_id',
                Auth::user()->department_id
            )
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

        $plos = ProgramLearningOutcome::with(['performanceIndicators' => function ($q) {
            $q->orderBy('code');
        }])
            ->where('program_id', $user->program_id)
            ->orderBy('code')
            ->get();

        // $pis = PerformanceIndicator::whereHas('programLearningOutcome', function ($q) use ($user) {
        //     $q->where('program_id', $user->program_id);
        // })
        //     ->orderBy('code')
        //     ->get();

        return view(
            'program_director.syllabus_shells.create',
            compact(
                'courses',
                'templates',
                'lecturers',
                'plos'
            )
        );
    }

    private function renderGeneralInfoHtml(array $data): string
    {
        return view('partials.syllabus.general_info', [
            'data' => $data,
        ])->render();
    }

    private function renderCourseDescriptionHtml(?string $description): string
    {
        return view('partials.syllabus.course_description', [
            'description' => $description,
        ])->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'template_id' => 'required|exists:syllabus_templates,id',
            'assigned_to' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:20',

            'pi_ids' => 'required|array|min:1',
            'pi_ids.*' => 'exists:performance_indicators,id',

            'planning_note' => 'nullable|string',
            'due_date' => 'nullable|date',

            'general_info' => 'nullable|array',
            'general_info.course_name' => 'nullable|string|max:255',
            'general_info.english_name' => 'nullable|string|max:255',
            'general_info.course_code' => 'nullable|string|max:50',
            'general_info.e_learning' => 'nullable|string|max:255',
            'general_info.credits' => 'nullable|integer|min:0',
            'general_info.theory_hours' => 'nullable|integer|min:0',
            'general_info.practice_hours' => 'nullable|integer|min:0',
            'general_info.self_study_hours' => 'nullable|integer|min:0',
            'general_info.prerequisite' => 'nullable|string',
            'general_info.previous_course' => 'nullable|string',
            'general_info.parallel_course' => 'nullable|string',

            'course_description' => 'nullable|string',
        ]);

        $user = Auth::user();

        $course = $this->getCourseInMyProgram($request->course_id);
        $template = $this->getTemplateInMyDepartment($request->template_id);
        $lecturer = $this->getLecturerInMyDepartment($request->assigned_to);

        $selectedPis = PerformanceIndicator::whereHas('programLearningOutcome', function ($q) use ($user) {
            $q->where('program_id', $user->program_id);
        })
            ->whereIn('id', $request->pi_ids)
            ->get();

        if ($selectedPis->count() !== count($request->pi_ids)) {
            abort(403, 'PI không thuộc CTĐT của bạn.');
        }

        $ploIds = $selectedPis
            ->pluck('plo_id')
            ->unique()
            ->values();

        DB::transaction(function () use ($request, $course, $template, $lecturer,  $selectedPis, $ploIds) {

            $assignedStatus = Status::where('status_name', 'Assigned')
                ->firstOrFail();

            $syllabus = Syllabus::create([
                'course_id' => $course->id,
                'template_id' => $template->id,
                'academic_year' => $request->academic_year,
                'created_by' => Auth::id(),
                'status_id' => $assignedStatus->id,
                'planning_note' => $request->planning_note,
                'due_date' => $request->due_date,
                'assigned_at' => now(),
            ]);

            SyllabusAssignment::create([
                'syllabus_id' => $syllabus->id,
                'user_id' => $lecturer->id,
                'assignment_role' => 'PRIMARY_AUTHOR',
                'assigned_by' => Auth::id(),
                'assigned_at' => now(),
            ]);

            $sections = SyllabusSection::where('template_id', $template->id)
                ->orderBy('display_order')
                ->get();

            $generalInfo = $request->input('general_info', []);
            $courseDescription = $request->input('course_description', '');

            foreach ($sections as $section) {

                $contentHtml = '';
                $contentRaw = null;

                if ($section->section_code === 'COURSE_INFO') {
                    $contentHtml = $this->renderGeneralInfoHtml($generalInfo);
                    $contentRaw = [
                        'type' => 'general_info',
                        'data' => $generalInfo,
                        'prefilled_by' => Auth::id(),
                        'prefilled_at' => now()->toDateTimeString(),
                    ];
                }

                if ($section->section_code === 'COURSE_DESCRIPTION') {
                    $contentHtml = $this->renderCourseDescriptionHtml($courseDescription);
                    $contentRaw = [
                        'type' => 'course_description',
                        'data' => [
                            'description' => $courseDescription,
                        ],
                        'prefilled_by' => Auth::id(),
                        'prefilled_at' => now()->toDateTimeString(),
                    ];
                }

                SyllabusContent::create([
                    'syllabus_id' => $syllabus->id,
                    'section_id' => $section->id,
                    'content_html' => $contentHtml,
                    'content_raw' => $contentRaw,
                ]);
            }

            foreach ($ploIds as $ploId) {
                SyllabusPloTarget::create([
                    'syllabus_id' => $syllabus->id,
                    'plo_id' => $ploId,
                ]);
            }

            foreach ($selectedPis as $pi) {
                SyllabusPiTarget::create([
                    'syllabus_id' => $syllabus->id,
                    'pi_id' => $pi->id,
                ]);
            }
        });

        return redirect()
            ->route('program_director.syllabus_shells.create')
            ->with(
                'success',
                'Tạo syllabus shell và phân công giảng viên thành công.'
            );
    }
}
