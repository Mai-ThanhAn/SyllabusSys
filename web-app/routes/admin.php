<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ApprovalRequestController;
use App\Http\Controllers\Admin\CourseController;

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

        Route::get(
            '/approval-requests',
            [ApprovalRequestController::class, 'index']
        )->name('approval.index');

        Route::post(
            '/approval-requests/{id}/approve',
            [ApprovalRequestController::class, 'approve']
        )->name('approval.approve');

        Route::post(
            '/approval-requests/{id}/reject',
            [ApprovalRequestController::class, 'reject']
        )->name('approval.reject');

        Route::prefix('admin')
            ->middleware(['auth'])
            ->group(function () {
                Route::resource('courses', CourseController::class);
            });
    });
