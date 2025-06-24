<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
     public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $logs = ActivityLog::with('user:id,name,email')
            ->orderByDesc('logged_at')
            ->get();

        return response()->json($logs);
    }
}
