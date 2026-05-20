<?php

namespace App\Http\Controllers\ProgramDirector;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\SyllabusApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SyllabusApprovalController extends Controller
{
    public function index()
    {
        $pendingStatus = Status::where('status_name', 'Pending')->firstOrFail();

        $approvals = SyllabusApproval::with([
            'version.syllabus.course',
            'version.syllabus.course.program',
            'version.creator',
        ])
            ->where('status_id', $pendingStatus->id)
            ->latest()
            ->get();

        return view('program_director.syllabus_approvals.index', compact('approvals'));
    }

    public function show(int $id)
    {
        $approval = SyllabusApproval::with([
            'version.syllabus.course.program',
            'version.contents.section',
            'version.courseObjectives',
            'version.courseLearningOutcomes',
            'version.teachingPlanItems.cloMappings',
        ])->findOrFail($id);

        return view('program_director.syllabus_approvals.show', compact('approval'));
    }

    public function approve(int $id)
    {
        $approval = SyllabusApproval::with('version.syllabus')
            ->findOrFail($id);

        DB::transaction(function () use ($approval) {
            $approvedStatus = Status::where('status_name', 'Approved')->firstOrFail();

            $approval->update([
                'status_id' => $approvedStatus->id,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            $approval->version->update([
                'status_id' => $approvedStatus->id,
            ]);

            $approval->version->syllabus->update([
                'status_id' => $approvedStatus->id,
            ]);
        });

        return redirect()
            ->route('department.syllabus-approvals.index')
            ->with('success', 'Đã duyệt đề cương.');
    }

    public function reject(Request $request, int $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $approval = SyllabusApproval::with('version.syllabus')
            ->findOrFail($id);

        DB::transaction(function () use ($approval, $request) {
            $rejectedStatus = Status::where('status_name', 'Rejected')->firstOrFail();

            $approval->update([
                'status_id' => $rejectedStatus->id,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'comment' => $request->comment,
            ]);

            $approval->version->update([
                'status_id' => $rejectedStatus->id,
            ]);

            $approval->version->syllabus->update([
                'status_id' => $rejectedStatus->id,
            ]);
        });

        return redirect()
            ->route('program-director.syllabus-approvals.index')
            ->with('success', 'Đã duyệt đề cương.');
    }
}
