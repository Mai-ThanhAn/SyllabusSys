<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversityAdmin\DashboardController;
use App\Http\Controllers\UniversityAdmin\UserRoleController;
use App\Http\Controllers\UniversityAdmin\DepartmentController;

Route::prefix('university-admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('university-admin.dashboard');

        Route::get('/users', [UserRoleController::class, 'index'])
            ->name('university-admin.users.index');

        Route::post('/users/{userId}/assign-role', [UserRoleController::class, 'assignRole'])
            ->name('university-admin.users.assignRole');

        Route::resource('departments', DepartmentController::class)
            ->names('university-admin.departments');

        // Route::post('/departments/{departmentId}/assign-head', [DepartmentController::class, 'assignHead'])
        //     ->name('university-admin.departments.assignHead');
    });
