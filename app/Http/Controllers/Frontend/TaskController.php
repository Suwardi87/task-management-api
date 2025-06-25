<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

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


    public function exportCsv(Request $request)
    {
        // Cek izin pengguna (hanya admin dan manager)
        if (!Gate::allows('export-tasks')) {
            abort(403, 'Unauthorized');
        }

        // Ambil query filter (jika ada)
        $status = $request->query('status');

        $query = Task::with('assignedTo');

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->get();

        // Header CSV
        $csvData = [];
        $csvData[] = ['Judul', 'Deskripsi', 'Status', 'Jatuh Tempo', 'Ditugaskan ke'];

        // Isi data
        foreach ($tasks as $task) {
            $csvData[] = [
                $task->title,
                $task->description ?? '-',
                ucfirst(str_replace('_', ' ', $task->status)),
                $task->due_date
                    ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d')
                    : '-',

                optional($task->assignedTo)->name ?? '-',
            ];
        }

        // Nama file export
        $filename = 'tasks_export_' . now()->format('Ymd_His') . '.csv';

        // Gunakan php://temp sebagai buffer memory
        $handle = fopen('php://temp', 'r+');

        // Tambahkan BOM agar Excel tidak rusak karakter UTF-8
        fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Tulis setiap baris ke CSV
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        // Log aktivitas export
        Log::channel('daily')->info('Export CSV oleh user: ' . auth()->user()->email, [
            'total_data' => count($tasks),
            'status_filter' => $status ?? 'all',
            'timestamp' => now()->toDateTimeString(),
        ]);

        // Kembalikan response CSV
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }
}
