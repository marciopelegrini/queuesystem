<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware(['guest'])->group(function (){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

//Auth routes
Route::middleware(['auth'])->group(function(){
    Route::get('/', function(){
        echo "Home Page";
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
