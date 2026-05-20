<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramDirector\SyllabusApprovalController;

Route::prefix('program-director')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/syllabus-approvals', [SyllabusApprovalController::class, 'index'])
            ->name('program-director.syllabus-approvals.index');

        Route::get('/syllabus-approvals/{id}', [SyllabusApprovalController::class, 'show'])
            ->name('program-director.syllabus-approvals.show');

        Route::post('/syllabus-approvals/{id}/approve', [SyllabusApprovalController::class, 'approve'])
            ->name('program-director.syllabus-approvals.approve');

        Route::post('/syllabus-approvals/{id}/reject', [SyllabusApprovalController::class, 'reject'])
            ->name('program-director.syllabus-approvals.reject');
    });
