<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\TestLoginController;


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

        Route::get('/choose-role', 'chooseRole')
            ->name('chooseRole');

        Route::post('/register-lecturer', 'storeLecturer')
            ->name('storeLecturer');

        Route::post('/logout', 'logout')
            ->name('logout');

        Route::get('/register-lecturer', 'registerLecturer')
            ->name('registerLecturer');

        Route::post('/register-lecturer', 'storeLecturer')
            ->name('storeLecturer');
    });

Route::get('/login', [TestLoginController::class, 'showLogin'])->name('login');
Route::post('/login', [TestLoginController::class, 'login'])->name('login.post');
Route::post('/logout', [TestLoginController::class, 'logout'])->name('logout');
