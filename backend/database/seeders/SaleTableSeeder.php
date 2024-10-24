<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleTableSeeder extends Seeder
{
    public function run(): void
    {
        Sale::factory()->count(30)->create();
    }
}
