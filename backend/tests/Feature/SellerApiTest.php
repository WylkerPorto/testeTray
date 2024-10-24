<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Crypt;

class SellerApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_seller()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/sellers', [
            'name' => 'Test Seller',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson(['name' => 'Test Seller']);
    }

    /** @test */
    public function it_can_get_a_seller()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->create();

        $encryptedId = Crypt::encryptString($seller->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/sellers/{$encryptedId}");

        $response->assertStatus(200)
            ->assertJson(['id' => $seller->id]);
    }

    /** @test */
    public function it_can_update_a_seller()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->create();

        $encryptedId = Crypt::encryptString($seller->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/sellers/{$encryptedId}", [
            'name' => 'Updated Seller',
            'email' => $seller->email,
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Seller']);
    }

    /** @test */
    public function it_can_delete_a_seller()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->create();

        $encryptedId = Crypt::encryptString($seller->id);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/sellers/{$encryptedId}");

        $response->assertStatus(204);
    }

    /** @test */
    public function it_can_get_all_sellers()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $seller = Seller::factory()->count(20)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/sellers');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
