<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\OtpController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

Route::middleware('guest')->group(function () {

    Route::prefix('/auth/otp')->name('auth.otp.')->group(function () {

        Route::controller(OtpController::class)->name('auth.')->group(function () {

            Route::post('/generate', 'generate')->name('generate');
            Route::post('/check', 'check')->name('check');
        });
    });
    
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'login']);
});
