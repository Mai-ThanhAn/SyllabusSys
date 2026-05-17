<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ApprovalRequestController;

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
    });
