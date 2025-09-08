<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Sucursal;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caja>
 */
class CajaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'sucursal_id' => Sucursal::inRandomOrder()->first()->id,
            'monto_inicial' => $this->faker->randomFloat(2, 100, 500),
            'estado' => 'abierta',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
