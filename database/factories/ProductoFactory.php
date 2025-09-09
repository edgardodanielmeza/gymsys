<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoriaProducto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence,
            'precio' => $this->faker->randomFloat(2, 5, 100),
            'stock' => $this->faker->numberBetween(10, 100),
            'sku' => $this->faker->unique()->ean8(),
            'categoria_id' => CategoriaProducto::inRandomOrder()->first()->id ?? null,
        ];
    }
}
