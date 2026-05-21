<?php

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
