<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramLearningOutcome;
use Illuminate\Http\Request;

class ProgramLearningOutcomeController extends Controller
{
    public function index(int $programId)
    {
        $program = Program::findOrFail($programId);

        $plos = ProgramLearningOutcome::where('program_id', $programId)
            ->orderBy('code')
            ->get();

        return view('admin.plos.index', compact('program', 'plos'));
    }

    public function create(int $programId)
    {
        $program = Program::findOrFail($programId);

        return view('admin.plos.create', compact('program'));
    }

    public function store(Request $request, int $programId)
    {
        $request->validate([
            'code' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        ProgramLearningOutcome::create([
            'program_id' => $programId,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('programs.plos.index', $programId)
            ->with('success', 'Thêm PLO thành công.');
    }

    public function edit(int $programId, int $ploId)
    {
        $program = Program::findOrFail($programId);

        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        return view('admin.plos.edit', compact('program', 'plo'));
    }

    public function update(Request $request, int $programId, int $ploId)
    {
        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        $request->validate([
            'code' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        $plo->update([
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('programs.plos.index', $programId)
            ->with('success', 'Cập nhật PLO thành công.');
    }

    public function destroy(int $programId, int $ploId)
    {
        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        $plo->delete();

        return redirect()
            ->route('programs.plos.index', $programId)
            ->with('success', 'Xóa PLO thành công.');
    }
}
