<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProgramDirector\SyllabusShellController;
use App\Http\Controllers\ProgramDirector\SyllabusApprovalController;
use App\Http\Controllers\ProgramDirector\DashboardController;


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
        ])->name('program_director.syllabus_shells.create');

        Route::post('/syllabus-shells', [
            SyllabusShellController::class,
            'store'
        ])->name('program_director.syllabus_shells.store');

        /*
        |--------------------------------------------------------------------------
        | Approval
        |--------------------------------------------------------------------------
        */

        Route::get('/syllabus-approvals', [
            SyllabusApprovalController::class,
            'index'
        ])->name('program_director.syllabus_approvals.index');

        Route::get('/syllabus-approvals/{id}', [
            SyllabusApprovalController::class,
            'show'
        ])->name('program_director.syllabus_approvals.show');

        Route::post('/syllabus-approvals/{id}/approve', [
            SyllabusApprovalController::class,
            'approve'
        ])->name('program_director.syllabus_approvals.approve');

        Route::post('/syllabus-approvals/{id}/reject', [
            SyllabusApprovalController::class,
            'reject'
        ])->name('program_director.syllabus_approvals.reject');

        Route::get('/syllabus-shells', [
            SyllabusShellController::class,
            'index'
        ])->name('program_director.syllabus_shells.index');


        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('program_director.dashboard');
    });
