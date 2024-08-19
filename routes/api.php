<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;

Route::middleware('guest')->group(function () {

    Route::post('register', RegisterController::class);
});
