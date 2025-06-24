<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Cek dan log semua task yang overdue (belum selesai tapi due date lewat)';

    public function handle()
    {
        $overdueTasks = Task::where('status', '!=', 'done')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get();

        foreach ($overdueTasks as $task) {
            ActivityLog::create([
                'user_id'    => $task->created_by,
                'action'     => 'task_overdue',
                'description' => "Task overdue: {$task->id}",
                'logged_at'  => now(),
            ]);
        }

        $this->info("Logged {$overdueTasks->count()} overdue task(s).");
    }

    public function scheduling(Schedule $schedule): void
    {
        $schedule->command($this->getName())->daily();
    }
}
