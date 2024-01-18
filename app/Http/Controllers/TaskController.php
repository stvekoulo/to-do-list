<?php

// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::all();
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $task = Task::create($validatedData);

            return response()->json(['task' => $task], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Task $task)
    {
        try {
            return response()->json(['task' => $task]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'string|max:255',
                'description' => 'nullable|string',
                'status' => ['string', Rule::in(['not_started', 'in_progress', 'completed'])],
            ]);

            $task->update($validatedData);

            return response()->json(['task' => $task]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStats()
    {
        try {
            $totalTasks = Task::count();
            $notStartedTasks = Task::where('status', 'not_started')->count();
            $inProgressTasks = Task::where('status', 'in_progress')->count();
            $completedTasks = Task::where('status', 'completed')->count();

            return response()->json([
                'total_tasks' => $totalTasks,
                'not_started_tasks' => $notStartedTasks,
                'in_progress_tasks' => $inProgressTasks,
                'completed_tasks' => $completedTasks,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function changeStatus(Task $task)
    {
        try {
            $currentStatus = $task->status;

            // Déterminez le nouveau statut en fonction de l'état actuel
            switch ($currentStatus) {
                case 'not_started':
                    $newStatus = 'in_progress';
                    break;
                case 'in_progress':
                    $newStatus = 'completed';
                    break;
                // Vous pouvez ajouter des cas supplémentaires selon vos besoins

                default:
                    // Gérez d'autres cas si nécessaire
                    return response()->json(['error' => 'Invalid task status'], 422);
            }

            // Mettez à jour le statut de la tâche
            $task->update(['status' => $newStatus]);

            return response()->json(['task' => $task]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
