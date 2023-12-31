<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ModelTestController;
use App\Http\Controllers\Api\ResultController;
use Illuminate\Support\Facades\Route;


//Login
Route::post('login', [LoginController::class, 'login']);
Route::get('test', [LoginController::class, 'test']);


//Protected Route
Route::middleware('auth:api')->group(function () {
    //Logout
    Route::post('/logout', [LoginController::class, 'logout']);



    // Showcase
    Route::get('/model/test', [ModelTestController::class, 'model']);

    //Attempt
    Route::POST('/attempt', [ModelTestController::class, 'attempt']);
    Route::POST('/answer/submit', [AnswerController::class, 'submit']);
    Route::POST('/answer/submit/done', [AnswerController::class, 'done']);
    Route::get('/result/list', [ResultController::class, 'resultList']);
    Route::get('/result/{id}', [ResultController::class, 'result']);


    //Request
    Route::get('/model/request/{id}', [ModelTestController::class, 'request']);
    Route::get('/performance', [ModelTestController::class, 'performance']);
    // Route::get('/model/request/{id}', [ModelTestController::class, 'request']); //Request to model

    Route::get('/result/download/{id}', [ResultController::class, 'downloadPDF']);
});
