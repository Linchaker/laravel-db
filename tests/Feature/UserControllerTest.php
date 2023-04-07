<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'mysql');
    }


    /** @test */
    public function can_get_all_users()
    {
        $users = User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertOk();
        $response->assertJsonCount(5);
    }

    /** @test */
    public function can_create_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        unset($userData['password']);
        $response->assertJsonFragment($userData);
    }

    /** @test */
    public function can_get_a_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/'.$user->id);

        $response->assertOk();
        $response->assertJsonFragment($user->toArray());
    }

    /** @test */
    public function can_update_a_user()
    {
        $user = User::factory()->create();

        $updatedUserData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ];

        $response = $this->putJson('/api/users/'.$user->id, $updatedUserData);

        $response->assertOk();
        $this->assertDatabaseHas('users', $updatedUserData);
        $response->assertJsonFragment($updatedUserData);
    }

    /** @test */
    public function can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/'.$user->id);

        $response->assertNoContent();
        $this->assertModelMissing($user);
    }
}
