<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoMembresia;

class TipoMembresiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Pase Diario',
                'descripcion' => 'Acceso por un solo día a todas las instalaciones.',
                'precio' => 5.00,
                'duracion_en_dias' => 1,
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Mensual',
                'descripcion' => 'Acceso por 30 días a todas las instalaciones.',
                'precio' => 35.00,
                'duracion_en_dias' => 30,
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Quincenal',
                'descripcion' => 'Acceso por 15 días a todas las instalaciones.',
                'precio' => 20.00,
                'duracion_en_dias' => 15,
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Anual',
                'descripcion' => 'Acceso por 365 días con descuento especial.',
                'precio' => 350.00,
                'duracion_en_dias' => 365,
                'activo' => true,
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoMembresia::create($tipo);
        }

        $this->command->info('Tipos de membresía de ejemplo creados.');
    }
}
