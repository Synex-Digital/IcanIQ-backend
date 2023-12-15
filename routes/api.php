<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);


//Protected Route
Route::middleware('auth:api')->group(function () {
    Route::get('/data', [RegisterController::class, 'index']);
    // Route::post('/another', [YourController::class, 'anotherMethod']);
    // Add more routes within this middleware group if needed
});
