<?php

use App\Http\Controllers\Lecturer\AIGenerationController;
use App\Http\Controllers\Lecturer\SyllabusAuthoringController;
use App\Http\Controllers\Lecturer\SyllabusExportController;
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

Route::post(
    '/syllabuses/{syllabusId}/ai/generate-co',
    [AIGenerationController::class, 'generateCO']
)
    ->name('lecturer.syllabuses.ai.generateCO');

Route::post(
    '/syllabuses/{syllabusId}/ai/accept-co',
    [AIGenerationController::class, 'acceptCO']
)->name('lecturer.syllabuses.ai.acceptCO');

Route::put(
    '/syllabuses/{syllabusId}/course-objectives',
    [AIGenerationController::class, 'updateCO']
)->name('lecturer.syllabuses.updateCO');

Route::post(
    '/syllabuses/{syllabusId}/ai/generate-clo',
    [AIGenerationController::class, 'generateCLO']
)->name('lecturer.syllabuses.ai.generateCLO');

Route::post(
    '/syllabuses/{syllabusId}/ai/accept-clo',
    [AIGenerationController::class, 'acceptCLO']
)->name('lecturer.syllabuses.ai.acceptCLO');

Route::put(
    '/syllabuses/{syllabusId}/course-learning-outcomes',
    [AIGenerationController::class, 'updateCLO']
)->name('lecturer.syllabuses.updateCLO');
Route::post(
    '/syllabuses/{syllabusId}/ai/generate-teaching-plan',
    [AIGenerationController::class, 'generateTeachingPlan']
)->name('lecturer.syllabuses.ai.generateTeachingPlan');
Route::post(
    '/syllabuses/{syllabusId}/ai/accept-teaching-plan',
    [AIGenerationController::class, 'acceptTeachingPlan']
)->name('lecturer.syllabuses.ai.acceptTeachingPlan');
Route::put(
    '/syllabuses/{syllabusId}/teaching-plan',
    [AIGenerationController::class, 'updateTeachingPlan']
)->name('lecturer.syllabuses.updateTeachingPlan');
Route::post(
    '/syllabuses/{syllabusId}/submit',
    [SyllabusAuthoringController::class, 'submitForApproval']
)->name('lecturer.syllabuses.submit');
Route::get('/lecturer/syllabuses/{id}/export-word', [
    SyllabusExportController::class,
    'exportWord'
])->name('lecturer.syllabuses.export_word');
