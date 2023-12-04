<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);


//Protected Route
Route::middleware('auth.api')->group(function () {
    Route::get('/register', [YourController::class, 'yourMethod']);
    Route::post('/another', [YourController::class, 'anotherMethod']);
    // Add more routes within this middleware group if needed
});
