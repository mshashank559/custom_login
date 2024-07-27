<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    // Display the task dashboard for the authenticated user
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('dashboard', compact('tasks'));
    }

    // Method to add a new task
    public function add(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'task' => 'required|string|max:255',
            'status' => 'required|string|in:pending,done',
        ]);

        // Create a new task for the authenticated user
        $task = new Task;
        $task->user_id = auth()->user()->id; // Assign task to the authenticated user
        $task->task = $request->task;
        $task->status = $request->status;
        $task->save();

        // Return a success response
        return response()->json([
            'status' => 1,
            'message' => 'Task added successfully!',
            'task' => $task
        ]);
    }

    // Method to delete a task
    public function delete($id)
    {
        // Find the task by ID and ensure it belongs to the authenticated user
        $task = Task::find($id);
        if ($task && $task->user_id === auth()->user()->id) { // Ensure the task belongs to the authenticated user
            $task->delete();
            return response()->json(['status' => 1, 'message' => 'Task deleted successfully!']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Task not found or unauthorized!']);
        }
    }
}
