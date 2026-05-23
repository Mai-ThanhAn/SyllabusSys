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
    private function getApprovalInMyProgram($id)
    {
        return SyllabusApproval::with([
            'version.syllabus.course.program',
            'version.contents.section',
            'version.courseObjectives',
            'version.courseLearningOutcomes',
            'version.teachingPlanItems.cloMappings',
        ])
            ->whereHas('version.syllabus.course', function ($q) {
                $q->where('program_id', Auth::user()->program_id);
            })
            ->findOrFail($id);
    }
    public function index()
    {
        $submittedStatus = Status::where('status_name', 'Submitted')->firstOrFail();

        $approvals = SyllabusApproval::with([
            'version.syllabus.course',
            'version.syllabus.course.program',
            'version.creator',
        ])
            ->where('status_id', $submittedStatus->id)
            ->whereHas('version.syllabus.course', function ($q) {
                $q->where('program_id', Auth::user()->program_id);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('program_director.syllabus_approvals.index', compact('approvals'));
    }

    public function show($id)
    {
        $approval = $this->getApprovalInMyProgram($id);

        $diffResult = null;

        $currentVersion = $approval->version;

        if ($currentVersion->base_version_id) {
            $baseVersion = \App\Models\SyllabusVersion::find($currentVersion->base_version_id);

            if ($baseVersion) {
                $diffResult = app(\App\Services\Syllabus\SyllabusDiffService::class)
                    ->buildDiff($baseVersion, $currentVersion);
            }
        }

        return view(
            'program_director.syllabus_approvals.show',
            compact('approval', 'diffResult')
        );
    }

    public function approve($id)
    {
        $approval = $this->getApprovalInMyProgram($id);

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

        // SỬA: Đúng route name theo file route của bạn
        return redirect()
            ->route('program_director.syllabus_approvals.index')
            ->with('success', 'Đã duyệt đề cương thành công!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|min:5',
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

        // SỬA: Đúng route name theo file route của bạn
        return redirect()
            ->route('program_director.syllabus_approvals.index')
            ->with('success', 'Đã từ chối đề cương.');
    }
}
