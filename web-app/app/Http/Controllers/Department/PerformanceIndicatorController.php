<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\PerformanceIndicator;
use App\Models\Program;
use App\Models\ProgramLearningOutcome;
use Illuminate\Http\Request;

class PerformanceIndicatorController extends Controller
{
    public function index(int $programId, int $ploId)
    {
        $program = Program::findOrFail($programId);

        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        $pis = PerformanceIndicator::where('plo_id', $ploId)
            ->orderBy('code')
            ->get();

        return view('department.programs.pis.index', compact('program', 'plo', 'pis'));
    }

    public function create(int $programId, int $ploId)
    {
        $program = Program::findOrFail($programId);

        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        return view('department.programs.pis.create', compact('program', 'plo'));
    }

    public function store(Request $request, int $programId, int $ploId)
    {
        ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        $request->validate([
            'code' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        PerformanceIndicator::create([
            'plo_id' => $ploId,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('department.programs.plos.pis.index', [$programId, $ploId])
            ->with('success', 'Thêm PI thành công.');
    }

    public function edit(int $programId, int $ploId, int $piId)
    {
        $program = Program::findOrFail($programId);

        $plo = ProgramLearningOutcome::where('program_id', $programId)
            ->findOrFail($ploId);

        $pi = PerformanceIndicator::where('plo_id', $ploId)
            ->findOrFail($piId);

        return view('department.programs.pis.edit', compact('program', 'plo', 'pi'));
    }

    public function update(Request $request, int $programId, int $ploId, int $piId)
    {
        $pi = PerformanceIndicator::where('plo_id', $ploId)
            ->findOrFail($piId);

        $request->validate([
            'code' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        $pi->update([
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('department.programs.plos.pis.index', [$programId, $ploId])
            ->with('success', 'Cập nhật PI thành công.');
    }

    public function destroy(int $programId, int $ploId, int $piId)
    {
        $pi = PerformanceIndicator::where('plo_id', $ploId)
            ->findOrFail($piId);

        $pi->delete();

        return redirect()
            ->route('department.programs.plos.pis.index', [$programId, $ploId])
            ->with('success', 'Xóa PI thành công.');
    }
}
