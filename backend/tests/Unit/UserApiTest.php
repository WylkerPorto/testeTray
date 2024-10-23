<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Crypt;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        // Cria um usuário para obter o token JWT
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Envia a requisição com o token JWT no cabeçalho Authorization
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Verifica se o status é 201 e se os dados são os esperados
        $response->assertStatus(201)
            ->assertJson(['name' => 'Test User']);
    }

    /** @test */
    public function it_can_get_a_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $encryptedId = Crypt::encryptString($user->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$encryptedId}");

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $encryptedId = Crypt::encryptString($user->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/users/{$encryptedId}");

        $response->assertStatus(204);

        // Verifique se o campo deleted_at foi preenchido (soft delete)
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_get_all_users()
    {
        User::factory()->count(10)->create();
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(10);
    }
}
