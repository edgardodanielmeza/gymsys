<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Miembro;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Asistencia;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creando datos de muestra...');

        // Crear categorías de productos
        $this->command->info('Creando categorías de producto...');
        $categorias = CategoriaProducto::factory()->count(5)->create();

        // Crear productos
        $this->command->info('Creando productos...');
        Producto::factory()->count(20)->create(['categoria_id' => $categorias->random()->id]);

        // Crear Miembros con historial
        $this->command->info('Creando miembros y su historial...');
        Miembro::factory()->count(50)->create()->each(function ($miembro) {
            // Crear historial de membresías
            $numMembresias = rand(1, 4);
            for ($i = 0; $i < $numMembresias; $i++) {
                $membresia = Membresia::factory()->create(['miembro_id' => $miembro->id]);

                // Crear pago para esa membresía
                Pago::factory()->create([
                    'membresia_id' => $membresia->id,
                    'monto' => $membresia->monto_pagado,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);

                // Crear historial de asistencias si la membresía estuvo activa
                if ($membresia->fecha_inicio < Carbon::now()) {
                    $diasParaAsistencia = $membresia->fecha_fin > Carbon::now()
                        ? Carbon::now()->diffInDays($membresia->fecha_inicio)
                        : $membresia->fecha_fin->diffInDays($membresia->fecha_inicio);

                    $numAsistencias = rand(0, $diasParaAsistencia / 2);
                    for ($j = 0; $j < $numAsistencias; $j++) {
                        Asistencia::factory()->create([
                            'miembro_id' => $miembro->id,
                            'fecha_hora_entrada' => Carbon::instance(fake()->dateTimeBetween($membresia->fecha_inicio, $membresia->fecha_fin)),
                        ]);
                    }
                }
            }
        });

        // Crear algunas ventas de productos
        $this->command->info('Creando ventas de productos...');
        $caja = \App\Models\Caja::firstWhere('estado', 'abierta');
        if (!$caja) {
            $caja = \App\Models\Caja::factory()->create([
                'user_id' => User::first()->id,
                'sucursal_id' => \App\Models\Sucursal::first()->id,
            ]);
        }

        for ($i=0; $i < 30; $i++) {
            $items = [];
            $totalVenta = 0;
            $numItems = rand(1, 3);

            for ($j=0; $j < $numItems; $j++) {
                $producto = Producto::inRandomOrder()->first();
                $cantidad = rand(1, 2);
                $subtotal = $producto->precio * $cantidad;

                $items[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'precio_total' => $subtotal,
                ];
                $totalVenta += $subtotal;
            }

            $venta = Venta::factory()->create([
                'caja_id' => $caja->id,
                'miembro_id' => Miembro::inRandomOrder()->first()->id,
                'total' => $totalVenta,
            ]);
            $venta->items()->createMany($items);
        }

        $this->command->info('Datos de muestra creados con éxito.');
    }
}
