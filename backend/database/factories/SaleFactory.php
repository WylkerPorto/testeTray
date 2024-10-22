<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente
            'value' => $this->faker->randomFloat(2, 10, 1000), // Valor entre 10 e 1000
        ];
    }
}

