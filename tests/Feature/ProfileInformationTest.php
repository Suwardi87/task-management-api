<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Membuat pengguna baru
    }

    public function test_profile_information_can_be_updated(): void
    {
        $this->actingAs($this->user);

        $this->put('/user/profile-information', [
            'name' => 'Test Name',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test Name', $this->user->fresh()->name);
        $this->assertEquals('test@example.com', $this->user->fresh()->email);
    }
}

