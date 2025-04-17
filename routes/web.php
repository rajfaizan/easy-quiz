<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserQuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route::get('/home', function () {
//     return view('user.quiz_home');
// })->name('home');

Route::resource('auth', AuthController::class);
Route::post('auth/login', [AuthController::class,'login'])->name('login');
Route::resource('quiz', UserQuizController::class);
Route::resource('teacher', TeacherController::class);
