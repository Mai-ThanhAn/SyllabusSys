<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRequest;
use App\Services\Auth\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRequestController extends Controller
{
    public function __construct(
        protected ApprovalService $approvalService
    ) {}

    public function index()
    {
        $requests = ApprovalRequest::with([
            'user',
        ])
        ->where('status', 'Pending')
        ->latest()
        ->get();

        return view('admin.approvals.index', [
            'requests' => $requests
        ]);
    }

    public function approve(int $id)
    {
        try {

            $request = ApprovalRequest::with('user')
                ->findOrFail($id);

            $this->approvalService->approve(
                $request,
                Auth::user()
            );

            return back()->with(
                'success',
                'Duyệt tài khoản thành công.'
            );

        } catch (\Exception $ex) {

            return back()->with(
                'error',
                $ex->getMessage()
            );
        }
    }

    public function reject(Request $httpRequest, int $id)
    {
        try {

            $request = ApprovalRequest::with('user')
                ->findOrFail($id);

            $this->approvalService->reject(
                $request,
                Auth::user(),
                $httpRequest->reason
            );

            return back()->with(
                'success',
                'Đã từ chối tài khoản.'
            );

        } catch (\Exception $ex) {

            return back()->with(
                'error',
                $ex->getMessage()
            );
        }
    }
}
