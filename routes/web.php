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

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('can:all')->group(function () {
        Route::get('/grant/create', [GrantController::class, 'create'])->name('grant.create');
        Route::get('/grant', [GrantController::class, 'index'])->name('grant.index');
        Route::get('/grant/{grant}/edit', [GrantController::class, 'edit'])->name('grant.edit');
        Route::put('/grant/{grant}', [GrantController::class, 'update'])->name('grant.update');
        Route::get('/grant/{grant}', [GrantController::class, 'show'])->name('grant.show');
    });

    Route::middleware('can:admin')->group(function () {
        Route::post('/grant', [GrantController::class, 'store'])->name('grant.store');
        Route::delete('/grant/{grant}', [GrantController::class, 'destroy'])->name('grant.destroy');
    });

    Route::middleware('can:all')->group(function () {
        Route::get('/academician/create', [AcademicianController::class, 'create'])->name('academician.create');
        Route::get('/academician', [AcademicianController::class, 'index'])->name('academician.index');
        Route::get('/academician/{academician}/edit', [AcademicianController::class, 'edit'])->name('academician.edit');
        Route::put('/academician/{academician}', [AcademicianController::class, 'update'])->name('academician.update');
        Route::get('/academician/{academician}', [AcademicianController::class, 'show'])->name('academician.show');
    });

    Route::middleware('can:admin')->group(function () {
        Route::post('/academician', [AcademicianController::class, 'store'])->name('academician.store');
        Route::delete('/academician/{academician}', [AcademicianController::class, 'destroy'])->name('academician.destroy');
    });

    Route::middleware('can:all')->group(function () {
        Route::resource('/milestone', MilestoneController::class);
    });

    Route::get('/profile', [UserController::class, 'index'])->name('user.index');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile/{user}', [UserController::class, 'update'])->name('user.update');
});
