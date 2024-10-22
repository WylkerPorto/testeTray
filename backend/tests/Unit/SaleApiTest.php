<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_sale()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/sales', [
            'user_id' => $user->id,
            'value' => 100.50,
        ]);

        $response->assertStatus(201)
            ->assertJson(['value' => 100.50]);
    }

    /** @test */
    public function it_can_get_a_sale()
    {
        $sale = Sale::factory()->create();

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/sales/{$sale->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $sale->id]);
    }

    /** @test */
    public function it_can_update_a_sale()
    {
        $sale = Sale::factory()->create();

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/sales/{$sale->id}", [
            'value' => 200.75,
        ]);

        $response->assertStatus(200)
            ->assertJson(['value' => 200.75]);
    }

    /** @test */
    public function it_can_delete_a_sale()
    {
        $sale = Sale::factory()->create();

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/sales/{$sale->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sales', [
            'id' => $sale->id,
        ]);
    }

    /** @test */
    public function it_can_get_all_sales()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Sale::factory()->count(10)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/sales');

        $response->assertStatus(200)
            ->assertJsonCount(10);
    }

    /** @test */
    public function it_can_get_all_sales_by_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Sale::factory()->count(10)->create();
        $sales = Sale::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$user->id}/sales");

        $response->assertStatus(200)
            ->assertJsonCount(10);

        $salesData = $response->json();

        foreach ($salesData as $sale) {
            $this->assertEquals($user->id, $sale['user_id'], 'A venda não pertence ao usuário correto.');
        }
    }
}

