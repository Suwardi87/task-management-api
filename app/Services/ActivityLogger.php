<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
     public function log(string $action = null, string $description = null): void
    {
        // Safety: jangan log kalau gak ada action
        if (! $action || ! Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'description'=> $description ?? '',
            'logged_at'  => now(),
        ]);
    }
}
