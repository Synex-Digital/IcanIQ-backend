<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\GetAnswerController;
use App\Http\Controllers\Admin\ModeltestController;
use App\Http\Controllers\Admin\QuestionChoiceController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin/register', [AdminController::class, 'admin_register'])->name('admin.register');
Route::post('/admin/store', [AdminController::class, 'admin_store'])->name('admin.store');
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin.login');
Route::post('/login/admin', [AdminController::class, 'login_admin'])->name('login.admin');


Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('class', ClassController::class);
    Route::resource('modeltest', ModeltestController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('student', StudentController::class);
    Route::resource('/questionchoice', QuestionChoiceController::class);
    Route::resource('answer', AnswerController::class);
    Route::post('/getanswer', [GetAnswerController::class, 'getanswer'])->name('getanswer');
});
