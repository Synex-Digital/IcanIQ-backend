<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ModelTestController;
use Illuminate\Support\Facades\Route;


//Login
Route::post('login', [LoginController::class, 'login']);


//Protected Route
Route::middleware('auth:api')->group(function () {
    //Logout
    Route::post('/logout', [LoginController::class, 'logout']);



    // Showcase
    Route::get('/model/test', [ModelTestController::class, 'model']);
    Route::get('/model', [ModelTestController::class, 'approvalModel']);



    //Request
    Route::get('/model/request/{id}', [ModelTestController::class, 'request']);
});
