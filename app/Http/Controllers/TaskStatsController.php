<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskStatsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (! in_array($user->role, ['admin', 'manager'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $today = now()->toDateString();

        return response()->json([
            'total_tasks'     => Task::count(),
            'done'            => Task::where('status', 'done')->count(),
            'in_progress'     => Task::where('status', 'in_progress')->count(),
            'pending'         => Task::where('status', 'pending')->count(),
            'overdue'         => Task::where('status', '!=', 'done')
                                      ->whereDate('due_date', '<', $today)
                                      ->count(),
        ]);
    }
}
