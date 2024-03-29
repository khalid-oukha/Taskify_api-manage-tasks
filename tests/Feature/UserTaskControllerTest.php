<?php

namespace Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UserTaskControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    private function authenticate()
    {
        $user = \App\Models\User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $token = JWTAuth::fromUser($user);

        return $token;
    }

    public function test_user_can_retrieve_tasks()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/usertask');

        $response->assertStatus(200);
    }

    public function test_user_can_create_a_task()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/usertask', [
            'name' => 'Test Task',
            'status' => 'to do',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['name' => 'Test Task']);
    }

    public function test_user_can_view_a_task()
    {
        $user = User::factory()->create(); // Create the user first
        $token = $this->authenticate($user); // Pass the user to authenticate method, if possible

        $task = \App\Models\Task::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/usertask/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    "id" => 13,
                    "name" => "build api",
                    "status" => "to do",
                    "createdAt" => "2024-02-28T10:11:06.000000Z",
                    "userName" => "hasan"
                ]
            ]);
    }



    public function test_user_can_update_a_task()
    {
        $token = $this->authenticate();
        $task = \App\Models\Task::factory()->create(['name' => 'Original Name']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/v1/usertask/' . $task->id, ['name' => 'Updated Name', 'status' => 'doing']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Name']);
    }

    public function test_user_can_delete_a_task()
    {
        $token = $this->authenticate();
        $task = \App\Models\Task::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/v1/usertask/' . $task->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
