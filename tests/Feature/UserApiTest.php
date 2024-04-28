<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a listagem de usuários.
     *
     * @return void
     */
    public function testUserIndex()
    {

        $users = User::factory()->create();

        // Chama a rota de listagem de usuários
        $response = $this->getJson('/api/users');


        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email']
                ]
            ]);
    }

    /**
     * Testa a criação de um usuário.
     *
     * @return void
     */
    public function testUserStore()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson(['data' => $userData]);
    }

    /**
     * Testa a visualização de um usuário.
     *
     * @return void
     */
    public function testUserShow()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => $user->toArray()]);
    }

    /**
     * Testa a atualização de um usuário.
     *
     * @return void
     */
    public function testUserUpdate()
    {
        $user = User::factory()->create();

        $newUserData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $newUserData);

        $response->assertStatus(200)
            ->assertJson(['data' => $newUserData]);
    }

    /**
     * Testa a exclusão de um usuário.
     *
     * @return void
     */
    public function testUserDestroy()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
