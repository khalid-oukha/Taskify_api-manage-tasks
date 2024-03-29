<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\UserTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


//api/v1

Route::group(['prefix'=> 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function () {
    Route::apiResource('task',TaskController::class);
    Route::apiResource('usertask', UserTaskController::class);
    Route::put('taskdone/{task}', [UserTaskController::class, 'CompleteTask']);
});

