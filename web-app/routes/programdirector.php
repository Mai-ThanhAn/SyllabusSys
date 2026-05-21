<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProgramDirector\SyllabusShellController;
use App\Http\Controllers\ProgramDirector\SyllabusApprovalController;

Route::prefix('program-director')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Syllabus Shell
        |--------------------------------------------------------------------------
        */

        Route::get('/syllabus-shells/create', [
            SyllabusShellController::class,
            'create'
        ])->name('program-director.syllabus-shells.create');

        Route::post('/syllabus-shells', [
            SyllabusShellController::class,
            'store'
        ])->name('program-director.syllabus-shells.store');

        /*
        |--------------------------------------------------------------------------
        | Approval
        |--------------------------------------------------------------------------
        */

        Route::get('/syllabus-approvals', [
            SyllabusApprovalController::class,
            'index'
        ])->name('program-director.syllabus-approvals.index');

        Route::get('/syllabus-approvals/{id}', [
            SyllabusApprovalController::class,
            'show'
        ])->name('program-director.syllabus-approvals.show');

        Route::post('/syllabus-approvals/{id}/approve', [
            SyllabusApprovalController::class,
            'approve'
        ])->name('program-director.syllabus-approvals.approve');

        Route::post('/syllabus-approvals/{id}/reject', [
            SyllabusApprovalController::class,
            'reject'
        ])->name('program-director.syllabus-approvals.reject');
    });
