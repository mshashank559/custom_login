<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        // Middleware for API key and Sanctum authentication
        $this->middleware(function ($request, $next) {
            if ($request->header('API_KEY') !== 'helloatg') {
                return response()->json(['status' => 0, 'message' => 'Invalid API key'], 401);
            }
            return $next($request);
        })->only(['indexApi', 'storeApi', 'showApi', 'updateStatusApi', 'destroyApi']);

        $this->middleware('auth:sanctum')->only(['indexApi', 'storeApi', 'showApi', 'updateStatusApi', 'destroyApi']);
        $this->middleware('auth')->except(['indexApi', 'storeApi', 'showApi', 'updateStatusApi', 'destroyApi']);
    }

    // Method to get all tasks for the authenticated user (Web)
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return view('dashboard', compact('tasks'));
    }

    // Method to get all tasks for the authenticated user (API)
    public function indexApi()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }

    // Method to store a new task for the authenticated user (Web)
    public function store(Request $request)
{
    $request->validate([
        'task' => 'required|string|max:255',
        'assignee' => 'required|string|max:255',
    ]);

    $task = new Task();
    $task->task = $request->task;
    $task->assignee = $request->assignee;
    $task->status = 'pending';
    $task->user_id = auth()->id();
    $task->save();

    return response()->json(['task' => $task]);
}

    // Method to store a new task for the authenticated user (API)
    public function storeApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string',
            'assignee' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::create([
            'task' => $request->task,
            'assignee' => $request->assignee,
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Task successfully created',
            'task' => $task
        ], 201);
    }

    // Method to show a specific task (API)
    public function showApi(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        return response()->json($task, 200);
    }

    // Method to update task status (Web)
    public function updateStatus(Request $request, Task $task)
{
    $task->status = $request->status;
    $task->save();

    return response()->json(['task' => $task]);
}

    // Method to update task status (API)
    public function updateStatusApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|integer|exists:tasks,id',
            'status' => 'required|string|in:pending,done',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::find($request->task_id);

        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 0,
                'message' => 'Task not found or unauthorized',
            ], 404);
        }

        $task->update(['status' => $request->status]);

        return response()->json([
            'status' => 1,
            'message' => "Task status updated to {$request->status}",
            'task' => $task,
        ], 200);
    }

    // Method to delete a task (Web)
    public function destroy(Task $task)
{
    $task->delete();

    return response()->json(['message' => 'Task deleted successfully']);
}

    // Method to delete a task (API)
    public function destroyApi(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Task successfully deleted',
        ], 200);
    }
}
