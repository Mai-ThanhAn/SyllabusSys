<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\SyllabusAssignment;
use App\Models\SyllabusContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyllabusAuthoringController extends Controller
{
    public function edit(int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

        $syllabus = Syllabus::with([
            'course.program',
            'template',
            'contents.section',
            'ploTargets.programLearningOutcome',
            'piTargets.performanceIndicator',
        ])->findOrFail($syllabusId);

        $contents = $syllabus->contents
            ->sortBy(fn($content) => $content->section->display_order ?? 999);

        return view('lecturer.syllabuses.edit', compact('syllabus', 'contents'));
    }

    public function update(Request $request, int $syllabusId)
    {
        $this->ensureAssigned($syllabusId);

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
}
