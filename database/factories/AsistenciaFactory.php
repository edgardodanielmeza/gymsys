<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Miembro;
use App\Models\Sucursal;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'miembro_id' => Miembro::factory(),
            'sucursal_id' => Sucursal::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'fecha_hora_entrada' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
