<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Seller;

class SalesPerSeller extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = Seller::factory()->create();
        Sale::factory()->count(30)->create([
            'seller_id' => $seller->id,
            'sale_date' => now()
        ]);
    }
}
