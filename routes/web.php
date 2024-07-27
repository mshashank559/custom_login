<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // Profile route
    Route::get('/profile', function () {
        return "Hi";
    });

    // Dashboard route for displaying user-specific tasks
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Task management routes for web
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Task management routes for API
    Route::get('/api/tasks', [TaskController::class, 'indexApi']);
    Route::post('/api/tasks', [TaskController::class, 'storeApi']);
    Route::get('/api/tasks/{task}', [TaskController::class, 'showApi']);
    Route::patch('/api/tasks/{task}/status', [TaskController::class, 'updateStatusApi']);
    Route::delete('/api/tasks/{task}', [TaskController::class, 'destroyApi']);
});
