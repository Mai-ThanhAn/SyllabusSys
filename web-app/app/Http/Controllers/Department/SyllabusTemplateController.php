<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\SyllabusTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyllabusTemplateController extends Controller
{
    public function index()
    {
        $templates = SyllabusTemplate::where(
            'department_id',
            Auth::user()->department_id
        )
            ->latest('id')
            ->get();

        return view('department.syllabus_templates.index', compact('templates'));
    }

    public function create()
    {
        $programs = Program::where(
            'department_id',
            Auth::user()->department_id
        )
            ->orderBy('name')
            ->get();

        return view(
            'department.syllabus_templates.create',
            compact('programs')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
        ]);

        SyllabusTemplate::create([
            'template_name' => $request->template_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'department_id' => Auth::user()->department_id,
            'program_id' => $request->program_id,
        ]);

        return redirect()
            ->route('department.syllabus-templates.index')
            ->with('success', 'Đã tạo khung đề cương.');
    }

    public function edit(int $id)
    {
        $template = SyllabusTemplate::findOrFail($id);

        return view('department.syllabus_templates.edit', compact('template'));
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
            ->route('department.syllabus-templates.index')
            ->with('success', 'Đã cập nhật khung đề cương.');
    }

    public function destroy(int $id)
    {
        SyllabusTemplate::findOrFail($id)->delete();

        return redirect()
            ->route('department.syllabus-templates.index')
            ->with('success', 'Đã xóa khung đề cương.');
    }
}
