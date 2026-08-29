<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $cantidadMax = fake()->numberBetween(1, Producto::CANTIDAD_MAXIMA_PERMITIDA);

        return [
            'viajero_id' => User::factory()->viajero(),
            'viaje_id' => fn (array $attributes) => Viaje::factory()->create([
                'viajero_id' => $attributes['viajero_id'],
            ]),
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->sentence(),
            'precio' => fake()->randomFloat(2, 10, 200),
            'fee_transporte' => fake()->randomFloat(2, 5, 40),
            'cantidad_max' => $cantidadMax,
            'cantidad_disponible' => $cantidadMax,
            'imagen_path' => null,
        ];
    }
}
