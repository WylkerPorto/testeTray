<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'seller_id' => Seller::factory(), // Cria um vendedor automaticamente
            'value' => $this->faker->randomFloat(2, 10, 1000), // Valor entre 10 e 1000
            'sale_date' => $this->faker->dateTime(),
        ];
    }
}

