<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
})->name('home');
Route::get('/login', function () {
    return view('loginwgoogle');
})->name('login');

require __DIR__ . '/authen.php';
require __DIR__ . '/programdirector.php';
require __DIR__ . '/lecturer.php';
require __DIR__ . '/admin.php';
