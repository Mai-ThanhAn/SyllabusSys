<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AccountController;

Route::get('auth/google', [AccountController::class, 'redirectToGoogle'])
    ->name('auth.google');

Route::get('auth/google/callback', [AccountController::class, 'handleGoogleCallback']);
