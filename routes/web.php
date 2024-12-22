<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\AcademicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MilestoneController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('/grant', GrantController::class);

Route::resource('/academician', AcademicianController::class);

Route::resource('/milestone',MilestoneController::class);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->name('user.index');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile/{user}', [UserController::class, 'update'])->name('user.update');
});

