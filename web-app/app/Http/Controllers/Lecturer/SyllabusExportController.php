<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\SyllabusAssignment;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SyllabusExportController extends Controller
{
    public function exportWord(int $syllabusId)
    {
        $isAssigned = SyllabusAssignment::where('syllabus_id', $syllabusId)
            ->where('user_id', Auth::id())
            ->exists();

        abort_unless($isAssigned, 403);

        $syllabus = Syllabus::with([
            'course.program',
            'template',
            'contents.section',
            'courseObjectives',
            'courseLearningOutcomes',
            'teachingPlanItems.cloMappings.clo',
        ])->findOrFail($syllabusId);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText(
            'ĐỀ CƯƠNG CHI TIẾT HỌC PHẦN',
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center']
        );

        $section->addTextBreak();

        $section->addText('Tên học phần: ' . $syllabus->course->course_name);
        $section->addText('Mã học phần: ' . $syllabus->course->course_code);
        $section->addText('Chương trình: ' . ($syllabus->course->program->name ?? ''));
        $section->addText('Năm học: ' . $syllabus->academic_year);

        $section->addTextBreak();

        foreach ($syllabus->contents->sortBy(fn($c) => $c->section->display_order ?? 999) as $content) {
            $sec = $content->section;
            $code = strtoupper(trim($sec->section_code ?? ''));

            $section->addText(
                ($sec->display_order ?? '') . '. ' . ($sec->title ?? ''),
                ['bold' => true, 'size' => 13]
            );
            if ($code === 'COURSE_INFO') {
                $info = $content->content_raw['data'] ?? [];
                $this->addGeneralInfoTable($section, $info);
            }

            if ($code === 'COURSE_OBJECTIVES') {
                foreach ($syllabus->courseObjectives as $co) {
                    $section->addText($co->code . ': ' . $co->description);
                }
            } elseif ($code === 'COURSE_LEARNING_OUTCOMES') {
                foreach ($syllabus->courseLearningOutcomes as $clo) {
                    $section->addText($clo->code . ': ' . $clo->description);
                }
            } elseif ($code === 'TEACHING_PLAN') {
                foreach ($syllabus->teachingPlanItems->sortBy('item_order') as $item) {
                    $section->addText('Buổi ' . $item->item_order . ': ' . $item->title, ['bold' => true]);
                    $section->addText(strip_tags(json_encode($item->content, JSON_UNESCAPED_UNICODE)));
                }
            } else {
                $section->addText(strip_tags($content->content_html ?? ''));
            }

            $section->addTextBreak();
        }

        $fileName = 'de-cuong-' . $syllabus->course->course_code . '.docx';
        $path = storage_path('app/' . $fileName);

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    private function addGeneralInfoTable($section, array $info): void
    {
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 100,
        ]);

        $rows = [
            ['Tên học phần', $info['course_name'] ?? ''],
            ['Tên tiếng Anh', $info['english_name'] ?? ''],
            ['Mã học phần', $info['course_code'] ?? ''],
            ['E-learning', $info['e_learning'] ?? ''],
            ['Số tín chỉ', $info['credits'] ?? ''],
            ['Số tiết lý thuyết', $info['theory_hours'] ?? ''],
            ['Số tiết thực hành', $info['practice_hours'] ?? ''],
            ['Tự học', ($info['self_study_hours'] ?? '') . ' tiết'],
            ['Học phần tiên quyết', $info['prerequisite'] ?? 'Không'],
            ['Học phần học trước', $info['previous_course'] ?? 'Không'],
            ['Học phần song hành', $info['parallel_course'] ?? 'Không'],
        ];

        foreach ($rows as [$label, $value]) {
            $table->addRow();
            $table->addCell(3500)->addText($label, ['bold' => true]);
            $table->addCell(6000)->addText((string) $value);
        }
    }
}
