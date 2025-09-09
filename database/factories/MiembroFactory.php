<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sucursal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Miembro>
 */
class MiembroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'documento_identidad' => $this->faker->unique()->numerify('########'),
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'fecha_nacimiento' => $this->faker->date(),
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'direccion' => $this->faker->address,
            'sucursal_id' => Sucursal::inRandomOrder()->first()->id ?? Sucursal::factory(),
            'activo' => true,
        ];
    }
}
