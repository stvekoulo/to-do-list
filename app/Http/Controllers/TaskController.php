<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:non débuté,en cours,terminé',
        ]);

        $task = Auth::user()->tasks()->create($request->all());
        return response()->json($task, 201);
    }

    //show task
    public function show(Task $task) {
        return response()->json($task);
    }
   
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:non débuté,en cours,terminé',
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    //change the status 
    public function changeStatus(Task $task) {
        $task->status = $task->status == 'non débuté' ? 'en cours' : 'terminé';
        $task->save();
        return response()->json($task, 200);
    }
}
