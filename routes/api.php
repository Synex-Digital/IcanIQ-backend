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

    //Attempt
    Route::POST('/attempt', [ModelTestController::class, 'attempt']);


    //Request
    Route::get('/model/request/{id}', [ModelTestController::class, 'request']); //Request to model
    Route::get('/model/request/{id}', [ModelTestController::class, 'request']); //Request to model

});
