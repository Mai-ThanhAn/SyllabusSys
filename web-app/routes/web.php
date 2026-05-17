<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('loginwgoogle');
})->name('login');

require __DIR__.'/authen.php';
