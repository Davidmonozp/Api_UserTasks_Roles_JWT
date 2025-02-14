<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas publicas

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Rutas privadas

Route::middleware([IsUserAuth::class])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'getUser');
    });

    Route::get('tasks', [TaskController::class, 'getTasks']);
    Route::post('/tasks', [TaskController::class, 'addTask']);
    Route::put('/tasks/{id}', [TaskController::class, 'updateTaskById']);
    Route::delete('/tasks/{id}', [TaskController::class, 'deleteTaskById']);



    Route::middleware([IsAdmin::class])->group(function () {

        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasks/{id}', 'getTaskById');
            // Route::put('/tasks/{id}', 'updateTaskById');
            // Route::delete('/tasks/{id}', 'deleteTaskById');
        });
    });
});
