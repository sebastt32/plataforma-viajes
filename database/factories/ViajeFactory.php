<?php

namespace Database\Factories;

use App\Enums\EstadoViaje;
use App\Enums\TipoViaje;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Viaje>
 */
class ViajeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'viajero_id' => User::factory()->viajero(),
            'origen' => fake()->city(),
            'destino' => fake()->city(),
            'tipo' => fake()->randomElement(TipoViaje::cases()),
            'fecha_salida' => fake()->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'notas' => fake()->optional()->sentence(),
            'estado' => EstadoViaje::Publicado,
            'imagen_path' => null,
        ];
    }
}
