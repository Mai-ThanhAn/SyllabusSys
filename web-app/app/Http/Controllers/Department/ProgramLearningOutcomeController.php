<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramLearningOutcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramLearningOutcomeController extends Controller
{
    private function getProgram($programId)
    {
        return Program::where('department_id', Auth::user()->department_id)
            ->findOrFail($programId);
    }

    public function index($programId)
    {
        $program = $this->getProgram($programId);

        $plos = ProgramLearningOutcome::where('program_id', $program->id)
            ->orderBy('code')
            ->get();

        return view('department.programs.plos.index', compact('program', 'plos'));
    }

    public function create($programId)
    {
        $program = $this->getProgram($programId);

        return view('department.programs.plos.create', compact('program'));
    }

    public function store(Request $request, $programId)
    {
        $program = $this->getProgram($programId);

        $request->validate([
            'code' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        ProgramLearningOutcome::create([
            'program_id' => $program->id,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('department.programs.plos.index', $program->id)
            ->with('success', 'Thêm PLO thành công.');
    }

    public function edit($programId, $ploId)
    {
        $program = $this->getProgram($programId);

        $plo = ProgramLearningOutcome::where('program_id', $program->id)
            ->findOrFail($ploId);

        return view('department.programs.plos.edit', compact('program', 'plo'));
    }

    public function update(Request $request, $programId, $ploId)
    {
        $program = $this->getProgram($programId);

        $plo = ProgramLearningOutcome::where('program_id', $program->id)
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
            ->route('department.programs.plos.index', $program->id)
            ->with('success', 'Cập nhật PLO thành công.');
    }

    public function destroy($programId, $ploId)
    {
        $program = $this->getProgram($programId);

        $plo = ProgramLearningOutcome::where('program_id', $program->id)
            ->findOrFail($ploId);

        $plo->delete();

        return redirect()
            ->route('department.programs.plos.index', $program->id)
            ->with('success', 'Xóa PLO thành công.');
    }
}
