<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membresia;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'membresia_id' => Membresia::factory(),
            'user_id' => User::inRandomOrder()->first()->id,
            'monto' => $this->faker->randomFloat(2, 20, 350),
            'metodo_pago' => 'efectivo',
            'fecha_pago' => $this->faker->dateTimeThisYear(),
        ];
    }
}
