<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Controllers\TaskStatsController;
use App\Http\Controllers\OverdueTaskController;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', \App\Http\Middleware\CheckUserStatus::class])
    ->group(function () {
        Route::apiResource('users', UserController::class)->only(['index', 'store', 'destroy']);
        Route::get('/tasks/stats', [TaskStatsController::class, 'index']);
        Route::get('/tasks/overdue', [OverdueTaskController::class, 'index']);
        Route::apiResource('tasks', TaskController::class);
        Route::get('/logs', [LogController::class, 'index']);
    });
