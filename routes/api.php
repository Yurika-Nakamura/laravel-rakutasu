<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/password/reset/request', [AuthController::class, 'sendPasswordResetEmail'])->name('password.reset');
Route::post('/password/reset/verify', [AuthController::class, 'verifyTokenAndEmail'])->name('password.verify');
Route::post('/password/reset', [AuthController::class, 'updatePassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/check-login', [AuthController::class, 'checkLogin']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/addProjectData', [ProjectController::class, 'addProjectData']);
    Route::get('/getHomeData', [UserController::class, 'getHomeData']);
    Route::get('/getAllProjectData', [ProjectController::class, 'getAllProjectData']);
    Route::get('/getProjectData', [ProjectController::class, 'getProjectData']);
    Route::get('/getTaskData', [TaskController::class, 'getTaskData']);
    Route::post('/addTaskData', [TaskController::class, 'addTaskData']);
});
