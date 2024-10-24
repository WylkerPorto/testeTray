<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Crypt;

class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_sale()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->create();


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/sales', [
            'seller_id' => $seller->id,
            'value' => 100.50,
            'sale_date' => now()->toDateTimeString(),
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

        $encryptedId = Crypt::encryptString($sale->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/sales/{$encryptedId}");

        $response->assertStatus(200)
            ->assertJson(['id' => $sale->id]);
    }

    /** @test */
    public function it_can_update_a_sale()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $sale = Sale::factory()->create();

        $encryptedId = Crypt::encryptString($sale->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/sales/{$encryptedId}", [
            'value' => 200.75,
        ]);

        $response->assertStatus(200)
            ->assertJson(['value' => 200.75]);
    }

    /** @test */
    public function it_can_delete_a_sale()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $sale = Sale::factory()->create();

        $encryptedId = Crypt::encryptString($sale->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/sales/{$encryptedId}");

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
            ->assertJsonCount(10, 'data');
    }

    /** @test */
    public function i_can_get_all_sales_by_seller(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->create();
        $sale = Sale::factory()->count(20)->create([
            'seller_id' => $seller->id
        ]);

        $encriptedId = Crypt::encryptString($seller->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/sellers/{$encriptedId}/sales");

        $response->assertStatus(200)
            ->assertJsonCount(20);
    }
}

