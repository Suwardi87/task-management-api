<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use App\Http\Controllers\Frontend\TaskController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\LogController;


// Halaman depan
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Hanya untuk user yang sudah login & terverifikasi
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Tasks - semua user dapat akses, tapi perlu validasi di controller untuk role-based logic
    Route::resource('tasks', TaskController::class);

    // Users - hanya admin & manager, bisa tambahkan middleware role jika diperlukan
    Route::middleware('can:view-users')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store']);
    });


Route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');

    // Logs - hanya admin
    // Route::middleware('can:view-logs')->get('/logs', [LogController::class, 'index'])->name('logs.index');
});
