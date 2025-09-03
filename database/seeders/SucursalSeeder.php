<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usamos DB::table para evitar problemas con el modelo en el seeder inicial.
        DB::table('sucursales')->insert([
            [
                'nombre' => 'Sucursal Central',
                'direccion' => 'Av. Principal 123, Ciudad',
                'telefono' => '0981123456',
                'email' => 'central@gymsys.com',
                'capacidad_maxima' => 150,
                'horario_operacion' => 'Lunes a Sábado de 06:00 a 22:00',
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sucursal Secundaria',
                'direccion' => 'Calle Secundaria 456, Ciudad',
                'telefono' => '0981654321',
                'email' => 'secundaria@gymsys.com',
                'capacidad_maxima' => 100,
                'horario_operacion' => 'Lunes a Viernes de 07:00 a 21:00',
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
