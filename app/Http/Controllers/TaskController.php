<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    protected ActivityLogger $logger;

    public function __construct(ActivityLogger $logger)
    {
        $this->logger = $logger;
    }

    public function index()
    {
       $tasks = Task::with(['assignedTo', 'creator'])
        ->latest()
        ->paginate(10);

    return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|uuid|exists:users,id',
            'due_date'    => 'required|date|after_or_equal:today',
        ]);

        $user = $request->user();

        // Manager hanya boleh assign ke staff
        if ($user->role === 'manager') {
            $targetUser = User::find($data['assigned_to']);
            if (! $targetUser || $targetUser->role !== 'staff') {
                return response()->json(['message' => 'Managers can only assign tasks to staff'], 403);
            }
        }

        $task = Task::create([
            ...$data,
            'created_by' => $user->id,
            'status'     => 'pending',
        ]);

        $this->logger->log('create_task', "User created task ID: {$task->id}");

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('assignedTo', 'createdBy');

        $this->logger->log('view_task', "User viewed task ID: {$task->id}");

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'in:pending,in_progress,done',
            'due_date'    => 'sometimes|date|after_or_equal:today',
        ]);

        $task->update($data);

        $this->logger->log('update_task', "User updated task ID: {$task->id}");

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        $this->logger->log('delete_task', "User deleted task ID: {$task->id}");

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
