<?php

use App\Http\Controllers\Department\CourseController;
use App\Http\Controllers\Admin\PerformanceIndicatorController;
use App\Http\Controllers\Department\ProgramLearningOutcomeController;
use App\Http\Controllers\Department\DashboardController;
use App\Http\Controllers\Department\DepartmentMemberController;
use App\Http\Controllers\Department\ProgramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Department\SyllabusTemplateController;
use App\Http\Controllers\Department\SyllabusSectionController;

Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {

        Route::resource('syllabus-templates', SyllabusTemplateController::class)
            ->names('department.syllabus-templates');

        Route::get(
            '/syllabus-templates/{templateId}/sections',
            [SyllabusSectionController::class, 'index']
        )->name('department.syllabus-templates.sections.index');

        Route::get(
            '/syllabus-templates/{templateId}/sections/create',
            [SyllabusSectionController::class, 'create']
        )->name('department.syllabus-templates.sections.create');

        Route::post(
            '/syllabus-templates/{templateId}/sections',
            [SyllabusSectionController::class, 'store']
        )->name('department.syllabus-templates.sections.store');

        Route::get(
            '/syllabus-templates/{templateId}/sections/{sectionId}/edit',
            [SyllabusSectionController::class, 'edit']
        )->name('department.syllabus-templates.sections.edit');

        Route::put(
            '/syllabus-templates/{templateId}/sections/{sectionId}',
            [SyllabusSectionController::class, 'update']
        )->name('department.syllabus-templates.sections.update');

        Route::delete(
            '/syllabus-templates/{templateId}/sections/{sectionId}',
            [SyllabusSectionController::class, 'destroy']
        )->name('department.syllabus-templates.sections.destroy');
    });

Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/members', [DepartmentMemberController::class, 'index'])
            ->name('department.members.index');

        Route::post('/members/{userId}/assign-program-director', [DepartmentMemberController::class, 'assignProgramDirector'])
            ->name('department.members.assignProgramDirector');
    });

Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('department.dashboard');
    });

Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('programs', ProgramController::class)
            ->names('department.programs');

        Route::post('/programs/{programId}/assign-director', [ProgramController::class, 'assignDirector'])
            ->name('department.programs.assignDirector');
    });
Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('courses', \App\Http\Controllers\Department\CourseController::class)
            ->names('department.courses');
    });

    Route::prefix('department')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PLO
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/programs/{programId}/plos',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'index']
        )->name('department.programs.plos.index');

        Route::get(
            '/programs/{programId}/plos/create',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'create']
        )->name('department.programs.plos.create');

        Route::post(
            '/programs/{programId}/plos',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'store']
        )->name('department.programs.plos.store');

        Route::get(
            '/programs/{programId}/plos/{ploId}/edit',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'edit']
        )->name('department.programs.plos.edit');

        Route::put(
            '/programs/{programId}/plos/{ploId}',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'update']
        )->name('department.programs.plos.update');

        Route::delete(
            '/programs/{programId}/plos/{ploId}',
            [\App\Http\Controllers\Department\ProgramLearningOutcomeController::class, 'destroy']
        )->name('department.programs.plos.destroy');

        /*
        |--------------------------------------------------------------------------
        | PI
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/programs/{programId}/plos/{ploId}/pis',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'index']
        )->name('department.programs.plos.pis.index');

        Route::get(
            '/programs/{programId}/plos/{ploId}/pis/create',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'create']
        )->name('department.programs.plos.pis.create');

        Route::post(
            '/programs/{programId}/plos/{ploId}/pis',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'store']
        )->name('department.programs.plos.pis.store');

        Route::get(
            '/programs/{programId}/plos/{ploId}/pis/{piId}/edit',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'edit']
        )->name('department.programs.plos.pis.edit');

        Route::put(
            '/programs/{programId}/plos/{ploId}/pis/{piId}',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'update']
        )->name('department.programs.plos.pis.update');

        Route::delete(
            '/programs/{programId}/plos/{ploId}/pis/{piId}',
            [\App\Http\Controllers\Department\PerformanceIndicatorController::class, 'destroy']
        )->name('department.programs.plos.pis.destroy');

    });
