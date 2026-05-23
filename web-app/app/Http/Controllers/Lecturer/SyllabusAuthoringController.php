<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\SyllabusAssignment;
use App\Models\SyllabusContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\SyllabusVersion;
use App\Models\SyllabusVersionContent;
use App\Models\SyllabusApproval;
use App\Models\SyllabusVersionCourseObjective;
use App\Models\SyllabusVersionCourseLearningOutcome;
use App\Models\SyllabusVersionTeachingPlanItem;
use App\Models\SyllabusVersionTeachingPlanCloMapping;
use Illuminate\Support\Facades\DB;
use App\Services\Syllabus\SyllabusDiffService;
use App\Services\AI\AIClient;

class SyllabusAuthoringController extends Controller
{
    protected AIClient $aiClient;

    protected SyllabusDiffService $diffService;
    public function __construct(
        AIClient $aiClient,
        SyllabusDiffService $diffService
    ) {
        $this->aiClient = $aiClient;
        $this->diffService = $diffService;
    }
    public function edit(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course.program',
            'template',
            'contents.section',
            'ploTargets.programLearningOutcome',
            'piTargets.performanceIndicator',
            'courseObjectives',
            'courseLearningOutcomes',
            'teachingPlanItems.cloMappings.clo',
        ])->findOrFail($syllabusId);

        $this->ensureEditable($syllabus);
        $contents = $syllabus->contents
            ->sortBy(fn($content) => $content->section->display_order ?? 999);

        return view('lecturer.syllabuses.edit', compact('syllabus', 'contents'));
    }

    public function update(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);
        $syllabus = Syllabus::with('status')->findOrFail($syllabusId);
        $this->ensureEditable($syllabus);
        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'nullable|string',
        ]);

        foreach ($request->contents as $contentId => $html) {
            SyllabusContent::where('id', $contentId)
                ->where('syllabus_id', $syllabusId)
                ->update([
                    'content_html' => $html,
                    'updated_at' => now(),
                ]);
        }

        return back()->with('success', 'Lưu đề cương thành công.');
    }

    private function ensureAssigned(int $syllabusId): void
    {
        $isAssigned = SyllabusAssignment::where('syllabus_id', $syllabusId)
            ->where('user_id', Auth::id())
            ->exists();

        abort_unless($isAssigned, 403, 'Bạn không có quyền chỉnh sửa đề cương này.');
    }
    public function submitForApproval(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course',
            'contents.section',
            'courseObjectives',
            'courseLearningOutcomes',
            'teachingPlanItems.cloMappings.clo',
        ])->findOrFail($syllabusId);

        $this->ensureEditable($syllabus);

        DB::transaction(function () use ($syllabus) {

            $submittedStatus = Status::where('status_name', 'Submitted')->firstOrFail();

            $latestVersionNumber = SyllabusVersion::where('syllabus_id', $syllabus->id)
                ->max('version_number');

            $versionNumber = ($latestVersionNumber ?? 0) + 1;

            $rejectedStatus = Status::where('status_name', 'Rejected')
                ->first();

            $lastRejectedVersion = null;

            if ($rejectedStatus) {

                $lastRejectedVersion = SyllabusVersion::where(
                    'syllabus_id',
                    $syllabus->id
                )
                    ->where(
                        'status_id',
                        $rejectedStatus->id
                    )
                    ->latest('id')
                    ->first();
            }

            $baseVersion = SyllabusVersion::where('syllabus_id', $syllabus->id)
                ->latest('id')
                ->first();

            $version = SyllabusVersion::create([
                'syllabus_id' => $syllabus->id,
                'version_number' => $versionNumber,
                'created_by' => Auth::id(),
                'status_id' => $submittedStatus->id,
                'submission_type' => $versionNumber === 1 ? 'submitted' : 'resubmitted',
                'base_version_id' => $baseVersion?->id,
                'note' => 'Giảng viên gửi đề cương duyệt.',
            ]);

            foreach ($syllabus->contents as $content) {
                SyllabusVersionContent::create([
                    'version_id' => $version->id,
                    'section_id' => $content->section_id,
                    'content_html' => $content->content_html,
                    'content_raw' => $content->content_raw,
                ]);
            }

            foreach ($syllabus->courseObjectives as $co) {
                SyllabusVersionCourseObjective::create([
                    'version_id' => $version->id,
                    'code' => $co->code,
                    'description' => $co->description,
                    'bloom_level' => $co->bloom_level,
                ]);
            }

            foreach ($syllabus->courseLearningOutcomes as $clo) {
                SyllabusVersionCourseLearningOutcome::create([
                    'version_id' => $version->id,
                    'code' => $clo->code,
                    'description' => $clo->description,
                    'bloom_level' => $clo->bloom_level,
                ]);
            }

            foreach ($syllabus->teachingPlanItems as $item) {
                $versionItem = SyllabusVersionTeachingPlanItem::create([
                    'version_id' => $version->id,
                    'item_order' => $item->item_order,
                    'title' => $item->title,
                    'content' => $item->content,
                    'teaching_activities' => $item->teaching_activities,
                    'learning_activities' => $item->learning_activities,
                    'assessment_activities' => $item->assessment_activities,
                ]);

                foreach ($item->cloMappings as $mapping) {
                    SyllabusVersionTeachingPlanCloMapping::create([
                        'version_teaching_plan_item_id' => $versionItem->id,
                        'clo_code' => $mapping->clo->code,
                    ]);
                }
            }

            if ($baseVersion) {
                $newVersion = SyllabusVersion::with([
                    'contents.section',
                    'courseObjectives',
                    'courseLearningOutcomes',
                    'teachingPlanItems.cloMappings',
                ])->find($version->id);

                $oldVersion = SyllabusVersion::with([
                    'contents.section',
                    'courseObjectives',
                    'courseLearningOutcomes',
                    'teachingPlanItems.cloMappings',
                ])->find($baseVersion->id);

                $diffPayload = [
                    'course_name' => $syllabus->course->course_name,
                    'from_version' => $oldVersion->version_number,
                    'to_version' => $newVersion->version_number,
                    'changes' => $this->diffService->buildDiff($oldVersion, $newVersion),
                ];

                $summary = $this->aiClient->generateSmartDiff($diffPayload);

                $version->update([
                    'ai_change_summary' => $summary,
                ]);
            }

            SyllabusApproval::create([
                'version_id' => $version->id,
                'approved_by' => null,
                'status_id' => $submittedStatus->id,
                'comment' => null,
                'approved_at' => null,
            ]);

            $syllabus->update([
                'status_id' => $submittedStatus->id,
            ]);
        });

        return redirect()
            ->route('lecturer.dashboard')
            ->with('success', 'Đã gửi đề cương để duyệt.');
    }

    private function ensureEditable(Syllabus $syllabus): void
    {
        $statusName = $syllabus->status->status_name ?? null;

        abort_if(
            in_array($statusName, ['Submitted', 'Approved']),
            403,
            'Đề cương đang chờ duyệt hoặc đã được duyệt, không thể chỉnh sửa.'
        );
    }
}
