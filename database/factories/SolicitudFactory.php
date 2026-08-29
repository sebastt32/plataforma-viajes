<?php

namespace Database\Factories;

use App\Enums\EstadoSolicitud;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitud>
 */
class SolicitudFactory extends Factory
{
    public function definition(): array
    {
        return [
            'comprador_id' => User::factory()->comprador(),
            'producto_id' => Producto::factory(),
            'cantidad' => 1,
            'estado' => EstadoSolicitud::Pendiente,
        ];
    }

    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => EstadoSolicitud::Confirmada,
        ]);
    }
}
