<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RankingController;
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
Route::post('quiz/score/{id}', [UserQuizController::class,'score'])->name('score');
Route::resource('teacher', TeacherController::class);
Route::get('/results', [TeacherController::class, 'results'])->name('results');
Route::resource('admin', AdminController::class);
Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
Route::resource('ranking', RankingController::class);
