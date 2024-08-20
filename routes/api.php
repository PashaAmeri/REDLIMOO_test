<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\OtpController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Post\Comments\CommentController;
use App\Http\Controllers\Api\Post\PostsController;
use App\Http\Controllers\Api\Post\WriterController;
use App\Http\Controllers\Api\User\ShowController as ProfileController;
use App\Http\Controllers\Api\User\UpdateInfoController;

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

// Posts public routes 
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/writer/{id}/posts', [WriterController::class, 'index']);

// comments public routes
Route::get('/posts/{id}/comments', [CommentController::class, 'index']);

Route::middleware('auth:api')->group(function () {

    // profile routes
    Route::get('/profile', ProfileController::class);
    Route::patch('/profile', UpdateInfoController::class);

    // Posts routes
    Route::post('/posts', [PostsController::class, 'store']);
    Route::put('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);

    // comments routes
    Route::post('/posts/comments', [CommentController::class, 'store']);
});
