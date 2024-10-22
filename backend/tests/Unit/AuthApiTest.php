<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        // Cria um usuário de teste
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'), // Necessário bcrypt para simular corretamente
        ]);

        // Tenta fazer login com as credenciais válidas
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Verifica se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta contém o token JWT
        $response->assertJsonStructure(['token']);
    }

    public function test_cannot_access_protected_route_without_token()
    {
        // Tenta acessar uma rota protegida sem token JWT
        $response = $this->getJson('/api/users');

        // Verifica se a resposta tem status 401 (Unauthorized)
        $response->assertStatus(401);
    }

    public function test_can_access_protected_route_with_valid_token()
    {
        // Cria um usuário e faz login para obter o token
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Faz login para pegar o token JWT
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Extrai o token da resposta de login
        $token = $loginResponse->json('token');

        // Tenta acessar a rota protegida com o token JWT
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/users');

        // Verifica se a resposta tem status 200 (OK)
        $response->assertStatus(200);
    }

    public function test_cannot_access_protected_route_with_invalid_token()
    {
        // Token JWT inválido
        $invalidToken = 'invalid-token';

        // Tenta acessar a rota protegida com um token inválido
        $response = $this->withHeader('Authorization', "Bearer $invalidToken")
            ->getJson('/api/users');

        // Verifica se a resposta tem status 401 (Unauthorized)
        $response->assertStatus(401);
    }
}
