<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sucursal::updateOrCreate(
            ['nombre' => 'Sucursal Central'],
            [
                'direccion' => 'Av. Principal 123, Ciudad',
                'telefono' => '0981123456',
                'email' => 'central@gymsys.com',
                'horario_operacion' => 'Lunes a Sábado de 06:00 a 22:00',
                'is_active' => true,
            ]
        );

        Sucursal::updateOrCreate(
            ['nombre' => 'Sucursal Secundaria'],
            [
                'direccion' => 'Calle Secundaria 456, Ciudad',
                'telefono' => '0971654321',
                'email' => 'secundaria@gymsys.com',
                'horario_operacion' => 'Lunes a Viernes de 07:00 a 21:00',
                'is_active' => true,
            ]
        );
    }
}
