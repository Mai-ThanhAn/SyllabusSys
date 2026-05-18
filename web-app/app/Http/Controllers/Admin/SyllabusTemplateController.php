<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SyllabusTemplate;
use Illuminate\Http\Request;

class SyllabusTemplateController extends Controller
{
    public function index()
    {
        $templates = SyllabusTemplate::latest()->get();

        return view('admin.syllabus_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.syllabus_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SyllabusTemplate::create([
            'template_name' => $request->template_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('syllabus-templates.index')
            ->with('success', 'Thêm khung đề cương thành công.');
    }

    public function edit(int $id)
    {
        $template = SyllabusTemplate::findOrFail($id);

        return view('admin.syllabus_templates.edit', compact('template'));
    }

    public function update(Request $request, int $id)
    {
        $template = SyllabusTemplate::findOrFail($id);

        $request->validate([
            'template_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $template->update([
            'template_name' => $request->template_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('syllabus-templates.index')
            ->with('success', 'Cập nhật khung đề cương thành công.');
    }

    public function destroy(int $id)
    {
        SyllabusTemplate::findOrFail($id)->delete();

        return redirect()
            ->route('syllabus-templates.index')
            ->with('success', 'Xóa khung đề cương thành công.');
    }
}
