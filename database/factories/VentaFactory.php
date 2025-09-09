<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Caja;
use App\Models\User;
use App\Models\Miembro;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'caja_id' => Caja::factory(),
            'user_id' => User::inRandomOrder()->first()->id,
            'miembro_id' => Miembro::inRandomOrder()->first()->id,
            'total' => $this->faker->randomFloat(2, 10, 200),
            'metodo_pago' => 'efectivo',
        ];
    }
}
