<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

//Auth routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    // Queue details
    Route::get('/queue/{id}', [MainController::class, 'queueDetails'])->name('queue.details');

    //Change password
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePasswordSubmit'])->name('change.password.submit');

    //Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
