<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Task management routes under Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // Add a new task
    Route::post('/tasks/add', [TaskController::class, 'add']);
    // Delete a task
    Route::delete('/tasks/{id}', [TaskController::class, 'delete']);
    // Update the status of a task (optional, if needed)
    Route::post('/tasks/status', [TaskController::class, 'updateStatus']);
});

// Endpoint to get the authenticated user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
