<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class OverdueTaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!in_array($user->role, ['admin', 'manager'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $tasks = Task::where('status', '!=', 'done')
            ->whereDate('due_date', '<', now())
            ->with('assignedTo:id,name,email', 'createdBy:id,name,email')
            ->orderBy('due_date')
            ->get();

        return response()->json($tasks);
    }
}
