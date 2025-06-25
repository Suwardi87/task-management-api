<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;

class TaskStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_stats_endpoint()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Task::factory()->count(3)->create(['status' => 'pending']);
        Task::factory()->count(2)->create(['status' => 'done']);

        $this->getJson('/api/tasks/stats')
            ->assertStatus(200)
            ->assertJsonFragment(['pending' => 3])
            ->assertJsonFragment(['done' => 2]);
    }
}
