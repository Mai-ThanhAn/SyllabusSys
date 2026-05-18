<?php

use App\Http\Controllers\Lecturer\SyllabusAuthoringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lecturer\LecturerDashboardController;

Route::prefix('lecturer')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [LecturerDashboardController::class, 'index'])
            ->name('lecturer.dashboard');
    });

Route::prefix('lecturer')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/syllabuses/{syllabusId}/edit', [SyllabusAuthoringController::class, 'edit'])
            ->name('lecturer.syllabuses.edit');

        Route::put('/syllabuses/{syllabusId}', [SyllabusAuthoringController::class, 'update'])
            ->name('lecturer.syllabuses.update');
    });
