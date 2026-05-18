<?php

use App\Http\Controllers\Admin\SyllabusSectionController;
use App\Http\Controllers\Admin\SyllabusTemplateController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ApprovalRequestController;
use App\Http\Controllers\Admin\InstructorCourseController;
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

        Route::get(
            '/courses/{courseId}/assign-lecturer',
            [InstructorCourseController::class, 'create']
        )->name('courses.assignLecturer');

        Route::post(
            '/courses/{courseId}/assign-lecturer',
            [InstructorCourseController::class, 'store']
        )->name('courses.storeLecturer');

        Route::delete(
            '/instructor-courses/{id}',
            [InstructorCourseController::class, 'destroy']
        )->name('instructorCourses.destroy');

        Route::prefix('admin')
            ->middleware(['auth'])
            ->group(function () {
                Route::resource('syllabus-templates', SyllabusTemplateController::class);
            });

        Route::prefix('admin')
            ->middleware(['auth'])
            ->group(function () {
                Route::get(
                    '/syllabus-templates/{templateId}/sections',
                    [SyllabusSectionController::class, 'index']
                )->name('syllabus-templates.sections.index');

                Route::get(
                    '/syllabus-templates/{templateId}/sections/create',
                    [SyllabusSectionController::class, 'create']
                )->name('syllabus-templates.sections.create');

                Route::post(
                    '/syllabus-templates/{templateId}/sections',
                    [SyllabusSectionController::class, 'store']
                )->name('syllabus-templates.sections.store');

                Route::get(
                    '/syllabus-templates/{templateId}/sections/{sectionId}/edit',
                    [SyllabusSectionController::class, 'edit']
                )->name('syllabus-templates.sections.edit');

                Route::put(
                    '/syllabus-templates/{templateId}/sections/{sectionId}',
                    [SyllabusSectionController::class, 'update']
                )->name('syllabus-templates.sections.update');

                Route::delete(
                    '/syllabus-templates/{templateId}/sections/{sectionId}',
                    [SyllabusSectionController::class, 'destroy']
                )->name('syllabus-templates.sections.destroy');
            });
    });
