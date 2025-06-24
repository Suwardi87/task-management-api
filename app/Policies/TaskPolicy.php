<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Siapa saja boleh lihat semua task tergantung peran.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']);
    }

    /**
     * Boleh lihat task jika dia adalah pembuat, assigned_to, atau admin.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->created_by ||
               $user->id === $task->assigned_to ||
               $user->role === 'admin';
    }

    /**
     * Admin & Manager boleh buat task.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    /**
     * Hanya admin atau pembuat task yang boleh update.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->role === 'admin' ||
               $user->id === $task->created_by;
    }

    /**
     * Hanya admin atau pembuat task yang boleh hapus.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->role === 'admin' ||
               $user->id === $task->created_by;
    }

    /**
     * Restore hanya boleh dilakukan oleh admin.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Force delete hanya boleh dilakukan oleh admin.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->role === 'admin';
    }
}
