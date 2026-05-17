<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AccountController;

Route::get('auth/google', [AccountController::class, 'loginWithGoogle'])
    ->name('auth.google');

Route::get('auth/google/callback', [AccountController::class, 'googleCallback'])
    ->name('auth.google.callback');
