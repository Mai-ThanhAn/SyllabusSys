<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lecturer\LecturerDashboardController;

Route::prefix('lecturer')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [LecturerDashboardController::class, 'index'])
            ->name('lecturer.dashboard');
    });
