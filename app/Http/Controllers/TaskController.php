<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.index');
    }

    public function all()
    {
        return Task::orderByDesc('created_at')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tasks,name'
        ]);

        return Task::create($validated);   // returns JSON 201
    }

    public function toggle(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return response()->noContent();    // 204
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();    // 204
    }
}


