<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AccountController;

Route::controller(AccountController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::get('/login', 'login')
            ->name('login');

        Route::get('/google', 'loginWithGoogle')
            ->name('google');

        Route::get('/google/callback', 'googleCallback')
            ->name('google.callback');

        Route::get('/choose-role', 'registerLecturer')
            ->name('chooseRole');

        Route::post('/register-lecturer', 'storeLecturer')
            ->name('storeLecturer');

        Route::post('/logout', 'logout')
            ->name('logout');
    });
