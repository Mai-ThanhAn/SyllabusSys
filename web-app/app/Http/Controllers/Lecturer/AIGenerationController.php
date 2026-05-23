<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\SyllabusAssignment;
use App\Models\AiGenerationLog;
use App\Services\AI\AIClient;
use Illuminate\Http\Request;
use App\Models\CourseObjective;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseLearningOutcome;
use App\Models\TeachingPlanItem;
use App\Models\TeachingPlanCloMapping;

class AIGenerationController extends Controller
{
    public function __construct(
        protected AIClient $aiClient
    ) {}

    private function ensureAiAllowed(Syllabus $syllabus, string $sectionCode): void
    {
        $allowed = $syllabus->template
            ->sections()
            ->where('section_code', $sectionCode)
            ->where('is_ai_generatable', true)
            ->exists();

        abort_unless($allowed, 403, 'Section này chưa được phép dùng AI.');
    }

    private function getCourseDescription(Syllabus $syllabus): string
    {
        $content = $syllabus->contents
            ->first(function ($content) {
                return $content->section?->section_code === 'COURSE_DESCRIPTION';
            });

        if (!$content) {
            return '';
        }

        $raw = $content->content_raw;

        if (is_array($raw) && isset($raw['data']['description'])) {
            return $raw['data']['description'];
        }

        return trim(strip_tags($content->content_html ?? ''));
    }

    public function generateCO(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course',
            'template.sections',
            'contents.section',
            'ploTargets.programLearningOutcome',
            'piTargets.performanceIndicator',
        ])->findOrFail($syllabusId);

        $this->ensureAiAllowed($syllabus, 'COURSE_OBJECTIVES');

        $payload = [
            'course_name' => $syllabus->course->course_name,
            'course_type' => 'theory',
            'credits' => $syllabus->course->credits,
            'course_description' => 'contents.section',
            'plos' => $syllabus->ploTargets->map(fn($t) => [
                'code' => $t->programLearningOutcome->code,
                'description' => $t->programLearningOutcome->description,
            ])->values()->toArray(),
            'pis' => $syllabus->piTargets->map(fn($t) => [
                'code' => $t->performanceIndicator->code,
                'description' => $t->performanceIndicator->description,
            ])->values()->toArray(),
            'style_examples' => [],
        ];

        $result = $this->aiClient->generateCO($payload);

        AiGenerationLog::create([
            'syllabus_id' => $syllabus->id,
            'section_code' => 'CO',
            'generation_type' => 'CO',
            'input_context' => $payload,
            'generated_output' => $result['generated_data'],
            'verification_result' => $result['verification'],
            'status' => 'pending',
            'model_name' => 'gemini',
        ]);

        return back()
            ->with('ai_result', $result)
            ->with('success', 'AI đã sinh CO. Vui lòng kiểm tra trước khi chấp nhận.');
    }

    private function ensureAssigned(int $syllabusId): void
    {
        $isAssigned = SyllabusAssignment::where('syllabus_id', $syllabusId)
            ->where('user_id', Auth::id())
            ->exists();

        abort_unless($isAssigned, 403);
    }

    public function acceptCO(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'course_objectives' => 'required|array',
            'course_objectives.*.code' => 'required|string|max:20',
            'course_objectives.*.description' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $syllabusId) {
            CourseObjective::where('syllabus_id', $syllabusId)->delete();

            foreach ($request->course_objectives as $co) {
                CourseObjective::create([
                    'syllabus_id' => $syllabusId,
                    'code' => $co['code'],
                    'description' => $co['description'],
                    'bloom_level' => null,
                ]);
            }
        });

        return redirect()
            ->route('lecturer.syllabuses.edit', $syllabusId)
            ->with('success', 'Đã chấp nhận và lưu CO vào đề cương.');
    }

    public function updateCO(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'course_objectives' => 'required|array',
        ]);

        foreach ($request->course_objectives as $id => $data) {

            $co = CourseObjective::where('syllabus_id', $syllabusId)
                ->findOrFail($id);

            $co->update([
                'description' => $data['description']
            ]);
        }

        return back()->with(
            'success',
            'Đã cập nhật Course Objectives.'
        );
    }

    public function generateCLO(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course',
            'courseObjectives',
            'ploTargets.programLearningOutcome',
            'piTargets.performanceIndicator',
        ])->findOrFail($syllabusId);
        $this->ensureAiAllowed($syllabus, 'COURSE_LEARNING_OUTCOMES');

        $payload = [
            'course_name' => $syllabus->course->course_name,
            'course_type' => 'theory',
            'credits' => $syllabus->course->credits,
            'course_description' => '',
            'course_objectives' => $syllabus->courseObjectives->map(fn($co) => [
                'code' => $co->code,
                'description' => $co->description,
            ])->values()->toArray(),
            'plos' => $syllabus->ploTargets->map(fn($t) => [
                'code' => $t->programLearningOutcome->code,
                'description' => $t->programLearningOutcome->description,
            ])->values()->toArray(),
            'pis' => $syllabus->piTargets->map(fn($t) => [
                'code' => $t->performanceIndicator->code,
                'description' => $t->performanceIndicator->description,
            ])->values()->toArray(),
            'topics' => [],
            'style_examples' => [],
        ];

        $result = $this->aiClient->generateCLO($payload);

        AiGenerationLog::create([
            'syllabus_id' => $syllabus->id,
            'section_code' => 'CLO',
            'generation_type' => 'CLO',
            'input_context' => $payload,
            'generated_output' => $result['generated_data'],
            'verification_result' => $result['verification'],
            'status' => 'pending',
            'model_name' => 'gemini',
        ]);

        return back()
            ->with('ai_result_clo', $result)
            ->with('success', 'AI đã sinh CLO. Vui lòng kiểm tra trước khi chấp nhận.');
    }

    public function acceptCLO(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'course_learning_outcomes' => 'required|array',
            'course_learning_outcomes.*.code' => 'required|string|max:20',
            'course_learning_outcomes.*.description' => 'required|string',
            'course_learning_outcomes.*.bloom_level' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $syllabusId) {
            CourseLearningOutcome::where('syllabus_id', $syllabusId)->delete();

            foreach ($request->course_learning_outcomes as $clo) {
                CourseLearningOutcome::create([
                    'syllabus_id' => $syllabusId,
                    'code' => $clo['code'],
                    'description' => $clo['description'],
                    'bloom_level' => $clo['bloom_level'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('lecturer.syllabuses.edit', $syllabusId)
            ->with('success', 'Đã chấp nhận và lưu CLO vào đề cương.');
    }

    public function updateCLO(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'course_learning_outcomes' => 'required|array',
        ]);

        foreach ($request->course_learning_outcomes as $id => $data) {
            $clo = CourseLearningOutcome::where('syllabus_id', $syllabusId)
                ->findOrFail($id);

            $clo->update([
                'description' => $data['description'],
                'bloom_level' => $data['bloom_level'] ?? null,
            ]);
        }

        return back()->with('success', 'Đã cập nhật CLO.');
    }
    public function generateTeachingPlan(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course',
            'courseObjectives',
            'courseLearningOutcomes',
            'ploTargets.programLearningOutcome',
            'piTargets.performanceIndicator',
        ])->findOrFail($syllabusId);

        $this->ensureAiAllowed($syllabus, 'TEACHING_PLAN');
        $payload = [
            'course_name' => $syllabus->course->course_name,
            'course_type' => 'theory',
            'credits' => $syllabus->course->credits,
            'theory_hours' => 45,
            'practice_hours' => 0,
            'course_description' => '',
            'course_objectives' => $syllabus->courseObjectives->map(fn($co) => [
                'code' => $co->code,
                'description' => $co->description,
            ])->values()->toArray(),
            'course_learning_outcomes' => $syllabus->courseLearningOutcomes->map(fn($clo) => [
                'code' => $clo->code,
                'description' => $clo->description,
            ])->values()->toArray(),
            'plos' => $syllabus->ploTargets->map(fn($t) => [
                'code' => $t->programLearningOutcome->code,
                'description' => $t->programLearningOutcome->description,
            ])->values()->toArray(),
            'pis' => $syllabus->piTargets->map(fn($t) => [
                'code' => $t->performanceIndicator->code,
                'description' => $t->performanceIndicator->description,
            ])->values()->toArray(),
            'topics' => [],
            'style_examples' => [],
        ];

        $result = $this->aiClient->generateTeachingPlan($payload);

        AiGenerationLog::create([
            'syllabus_id' => $syllabus->id,
            'section_code' => 'TEACHING_PLAN',
            'generation_type' => 'TEACHING_PLAN',
            'input_context' => $payload,
            'generated_output' => $result['generated_data'],
            'verification_result' => $result['verification'],
            'status' => 'pending',
            'model_name' => 'gemini',
        ]);

        return back()
            ->with('ai_result_teaching_plan', $result)
            ->with('success', 'AI đã sinh kế hoạch giảng dạy.');
    }
    public function acceptTeachingPlan(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'teaching_plan' => 'required|array',
            'teaching_plan.*.order' => 'required|integer',
            'teaching_plan.*.title' => 'required|string|max:255',
            'teaching_plan.*.content' => 'nullable|array',
            'teaching_plan.*.teaching_activities' => 'nullable|array',
            'teaching_plan.*.learning_activities' => 'nullable|array',
            'teaching_plan.*.assessment_activities' => 'nullable|array',
            'teaching_plan.*.mapped_clo' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $syllabusId) {
            TeachingPlanItem::where('syllabus_id', $syllabusId)->delete();

            $cloMap = CourseLearningOutcome::where('syllabus_id', $syllabusId)
                ->get()
                ->keyBy('code');

            foreach ($request->teaching_plan as $item) {
                $planItem = TeachingPlanItem::create([
                    'syllabus_id' => $syllabusId,
                    'item_order' => $item['order'],
                    'title' => $item['title'],
                    'content' => $item['content'] ?? [],
                    'teaching_activities' => $item['teaching_activities'] ?? [],
                    'learning_activities' => $item['learning_activities'] ?? [],
                    'assessment_activities' => $item['assessment_activities'] ?? [],
                ]);

                foreach (($item['mapped_clo'] ?? []) as $cloCode) {
                    if (!isset($cloMap[$cloCode])) {
                        continue;
                    }

                    TeachingPlanCloMapping::create([
                        'teaching_plan_item_id' => $planItem->id,
                        'clo_id' => $cloMap[$cloCode]->id,
                    ]);
                }
            }
        });

        return redirect()
            ->route('lecturer.syllabuses.edit', $syllabusId)
            ->with('success', 'Đã chấp nhận và lưu kế hoạch giảng dạy.');
    }
    public function updateTeachingPlan(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $request->validate([
            'teaching_plan' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $syllabusId) {
            foreach ($request->teaching_plan as $itemId => $data) {
                $item = TeachingPlanItem::where('syllabus_id', $syllabusId)
                    ->findOrFail($itemId);

                $item->update([
                    'title' => $data['title'],
                    'content' => $data['content'] ?? [],
                    'teaching_activities' => $data['teaching_activities'] ?? [],
                    'learning_activities' => $data['learning_activities'] ?? [],
                    'assessment_activities' => $data['assessment_activities'] ?? [],
                ]);

                TeachingPlanCloMapping::where('teaching_plan_item_id', $item->id)->delete();

                $validCloIds = CourseLearningOutcome::where('syllabus_id', $syllabusId)
                    ->pluck('id')
                    ->toArray();

                foreach (($data['mapped_clo_ids'] ?? []) as $cloId) {
                    if (!in_array((int) $cloId, $validCloIds, true)) {
                        continue;
                    }

                    TeachingPlanCloMapping::create([
                        'teaching_plan_item_id' => $item->id,
                        'clo_id' => $cloId,
                    ]);
                }
            }
        });

        return back()->with('success', 'Đã cập nhật kế hoạch giảng dạy.');
    }
}
