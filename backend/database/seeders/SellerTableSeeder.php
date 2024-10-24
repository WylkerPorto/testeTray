<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;

class SellerTableSeeder extends Seeder
{
    public function run(): void
    {
        Seller::factory()->count(30)->create();
    }
}
