<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\GetAnswerController;
use App\Http\Controllers\Admin\ModeltestController;
use App\Http\Controllers\Admin\PanelUserController;
use App\Http\Controllers\Admin\QuestionChoiceController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TestController;
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
//Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/admin/register', [AdminController::class, 'admin_register'])->name('admin.register');
Route::post('/admin/store', [AdminController::class, 'admin_store'])->name('admin.store');
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin.login');
Route::post('/login/admin', [AdminController::class, 'login_admin'])->name('login.admin');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('class', ClassController::class);
    Route::resource('modeltest', ModeltestController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('student', StudentController::class);
    Route::resource('banner', BannersController::class);
    Route::resource('questionchoice', QuestionChoiceController::class);
    Route::resource('answer', AnswerController::class);
    Route::resource('panel-user', PanelUserController::class);
    Route::resource('requests', RequestController::class);
    Route::resource('tests', TestController::class);
    Route::post('/getanswer', [GetAnswerController::class, 'getanswer'])->name('getanswer');
    Route::post('/attempt/all', [RequestController::class, 'attempt_all'])->name('attempt.all');
    Route::post('/modeltest/soft/delete/{id}', [ModeltestController::class, 'modeltest_soft_delete'])->name('modeltest.soft.delete');
    Route::get('/performance', [PerformanceController::class, 'list'])->name('performance.list');
    Route::get('/performance/attempt/{id}', [PerformanceController::class, 'attempt_list'])->name('performance.list.attempt');
    Route::get('/performance/done/{id}', [PerformanceController::class, 'attempt_done'])->name('performance.attempt.done');
    Route::post('/getprints', [TestController::class, 'getprints'])->name('getprints');
    Route::get('/result/download/{id}', [TestController::class, 'download'])->name('result.download');
    Route::get('/result/list', [ResultController::class, 'result'])->name('admin.result.list');
});
