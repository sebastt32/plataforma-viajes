<?php

namespace Database\Seeders;

use App\Enums\EstadoSolicitud;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $comprador = User::query()->where('email', UserSeeder::COMPRADOR_EMAIL)->firstOrFail();

        $this->call(ViajeSeeder::class);

        $viajeMiami = Viaje::query()->where('origen', 'Bogotá')->where('destino', 'Miami')->where('tipo', 'negocios')->first()
            ?? Viaje::query()->where('origen', 'Bogotá')->where('destino', 'Miami')->first();
        $viajeMadrid = Viaje::query()->where('origen', 'Bogotá')->where('destino', 'Madrid')->first();

        if ($viajeMiami) {
            $auriculares = Producto::factory()->create([
                'viajero_id' => $viajeMiami->viajero_id,
                'viaje_id' => $viajeMiami->id,
                'nombre' => 'Auriculares inalámbricos',
                'descripcion' => 'Modelo con cancelación de ruido.',
                'precio' => 89.90,
                'fee_transporte' => 15.00,
                'cantidad_max' => 3,
                'cantidad_disponible' => 2,
                'imagen_externa_url' => DemoImageUrls::producto('Auriculares inalámbricos'),
            ]);

            Solicitud::factory()->create([
                'comprador_id' => $comprador->id,
                'producto_id' => $auriculares->id,
                'cantidad' => 1,
                'estado' => EstadoSolicitud::Pendiente,
            ]);
        }

        if ($viajeMadrid) {
            Producto::factory()->create([
                'viajero_id' => $viajeMadrid->viajero_id,
                'viaje_id' => $viajeMadrid->id,
                'nombre' => 'Aceite de oliva premium',
                'descripcion' => 'Botella de 500 ml.',
                'precio' => 24.50,
                'fee_transporte' => 8.00,
                'cantidad_max' => 3,
                'cantidad_disponible' => 3,
                'imagen_externa_url' => DemoImageUrls::producto('Aceite de oliva premium'),
            ]);
        }
    }
}
