<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ModelTestController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);


//Protected Route
Route::middleware('auth:api')->group(function () {
    Route::get('/model/test', [ModelTestController::class, 'model']);
});
