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
        $suplementos = CategoriaProducto::create(['nombre' => 'Suplementos']);
        $bebidas = CategoriaProducto::create(['nombre' => 'Bebidas']);
        $accesorios = CategoriaProducto::create(['nombre' => 'Accesorios']);

        // Crear productos
        $this->command->info('Creando productos de muestra...');
        $productos = [
            ['nombre' => 'Proteína Whey 1kg', 'descripcion' => 'Proteína de suero de leche para recuperación muscular.', 'precio' => 55.00, 'costo' => 35.00, 'stock' => 50, 'categoria_id' => $suplementos->id],
            ['nombre' => 'Creatina Monohidratada 300g', 'descripcion' => 'Mejora el rendimiento y la fuerza.', 'precio' => 25.00, 'costo' => 15.00, 'stock' => 80, 'categoria_id' => $suplementos->id],
            ['nombre' => 'BCAA 2:1:1', 'descripcion' => 'Aminoácidos de cadena ramificada.', 'precio' => 30.00, 'costo' => 20.00, 'stock' => 60, 'categoria_id' => $suplementos->id],
            ['nombre' => 'Agua Mineral 500ml', 'descripcion' => 'Botella de agua sin gas.', 'precio' => 1.00, 'costo' => 0.40, 'stock' => 200, 'categoria_id' => $bebidas->id],
            ['nombre' => 'Bebida Energética', 'descripcion' => 'Bebida para un impulso de energía.', 'precio' => 2.50, 'costo' => 1.20, 'stock' => 100, 'categoria_id' => $bebidas->id],
            ['nombre' => 'Guantes de Entrenamiento', 'descripcion' => 'Guantes para levantamiento de pesas.', 'precio' => 15.00, 'costo' => 8.00, 'stock' => 40, 'categoria_id' => $accesorios->id],
            ['nombre' => 'Cinturón de Levantamiento', 'descripcion' => 'Soporte lumbar para levantamientos pesados.', 'precio' => 40.00, 'costo' => 25.00, 'stock' => 25, 'categoria_id' => $accesorios->id],
            ['nombre' => 'Shaker', 'descripcion' => 'Botella mezcladora para batidos.', 'precio' => 8.00, 'costo' => 4.50, 'stock' => 70, 'categoria_id' => $accesorios->id],
            ['nombre' => 'Toalla de Microfibra', 'descripcion' => 'Toalla pequeña para el sudor.', 'precio' => 10.00, 'costo' => 5.00, 'stock' => 50, 'categoria_id' => $accesorios->id],
            ['nombre' => 'Barra de Proteína', 'descripcion' => 'Snack rápido alto en proteínas.', 'precio' => 3.00, 'costo' => 1.50, 'stock' => 120, 'categoria_id' => $suplementos->id],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }

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
