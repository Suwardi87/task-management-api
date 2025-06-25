<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $query = Task::with(['assignedTo', 'creator']);

    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    $tasks = $query->latest()->paginate(10)->withQueryString();

    return Inertia::render('Tasks/TaskList', [
        'tasks' => TaskResource::collection($tasks),
        'filters' => $request->only('status'),
    ]);
}


    public function create()
    {
        return Inertia::render('Tasks/TaskForm', [
            'users' => User::select('id', 'name')->get(),
            'task' => null, // penting: pastikan null agar form kosong
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,done',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
{
    $this->authorize('update', $task);

    $task->load(['assignedTo', 'creator']); // pastikan relasi loaded

    return Inertia::render('Tasks/EditTask', [
        'task' => new TaskResource($task),
        'users' => User::select('id', 'name')->get(),
    ]);
}


    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,done',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully.');
    }

    public function show(Task $task)
{
    $this->authorize('view', $task);

    $task->load(['assignedTo', 'creator']);

    return Inertia::render('Tasks/TaskDetail', [
        'task' => (new TaskResource($task))->toArray(request()),
    ]);
}

   public function destroy(Task $task)
{
    $this->authorize('delete', $task); // pastikan pakai policy kalau perlu
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
}


}
