<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Miembro;
use App\Models\TipoMembresia;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membresia>
 */
class MembresiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipoMembresia = TipoMembresia::inRandomOrder()->first();
        $fechaInicio = Carbon::instance($this->faker->dateTimeBetween('-2 years', 'now'));
        $fechaFin = $fechaInicio->copy()->addDays($tipoMembresia->duracion_en_dias);

        return [
            'miembro_id' => Miembro::factory(),
            'tipo_membresia_id' => $tipoMembresia->id,
            'sucursal_id' => Sucursal::inRandomOrder()->first()->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => $fechaFin < Carbon::now() ? 'vencida' : 'activa',
            'monto_pagado' => $tipoMembresia->precio,
        ];
    }
}
