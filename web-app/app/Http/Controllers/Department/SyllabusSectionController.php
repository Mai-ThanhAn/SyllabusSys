<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\SyllabusSection;
use App\Models\SyllabusTemplate;
use Illuminate\Http\Request;

class SyllabusSectionController extends Controller
{
    public function index(int $templateId)
    {
        $template = SyllabusTemplate::findOrFail($templateId);

        $sections = SyllabusSection::where('template_id', $templateId)
            ->orderBy('display_order')
            ->get();

        return view('department.syllabus_sections.index', compact('template', 'sections'));
    }

    public function create(int $templateId)
    {
        $template = SyllabusTemplate::findOrFail($templateId);

        return view('department.syllabus_sections.create', compact('template'));
    }

    public function store(Request $request, int $templateId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'section_code' => 'required|string|max:50',
            'display_order' => 'required|integer|min:1',
            'input_type' => 'required|string|max:50',
        ]);

        SyllabusSection::create([
            'template_id' => $templateId,
            'title' => $request->title,
            'section_code' => $request->section_code,
            'display_order' => $request->display_order,
            'input_type' => $request->input_type,
            'is_required' => $request->has('is_required'),
            'is_editable' => $request->has('is_editable'),
            'is_ai_generatable' => $request->has('is_ai_generatable'),
        ]);

        return redirect()
            ->route('department.syllabus-templates.sections.index', $templateId)
            ->with('success', 'Đã thêm section.');
    }

    public function edit(int $templateId, int $sectionId)
    {
        $template = SyllabusTemplate::findOrFail($templateId);

        $section = SyllabusSection::where('template_id', $templateId)
            ->findOrFail($sectionId);

        return view('department.syllabus_sections.edit', compact('template', 'section'));
    }

    public function update(Request $request, int $templateId, int $sectionId)
    {
        $section = SyllabusSection::where('template_id', $templateId)
            ->findOrFail($sectionId);

        $request->validate([
            'title' => 'required|string|max:255',
            'section_code' => 'required|string|max:50',
            'display_order' => 'required|integer|min:1',
            'input_type' => 'required|string|max:50',
        ]);

        $section->update([
            'title' => $request->title,
            'section_code' => $request->section_code,
            'display_order' => $request->display_order,
            'input_type' => $request->input_type,
            'is_required' => $request->has('is_required'),
            'is_editable' => $request->has('is_editable'),
            'is_ai_generatable' => $request->has('is_ai_generatable'),
        ]);

        return redirect()
            ->route('department.syllabus-templates.sections.index', $templateId)
            ->with('success', 'Đã cập nhật section.');
    }

    public function destroy(int $templateId, int $sectionId)
    {
        $section = SyllabusSection::where('template_id', $templateId)
            ->findOrFail($sectionId);

        $section->delete();

        return redirect()
            ->route('department.syllabus-templates.sections.index', $templateId)
            ->with('success', 'Đã xóa section.');
    }
}
