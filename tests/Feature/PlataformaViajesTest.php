<?php

namespace Tests\Feature;

use App\Enums\EstadoPago;
use App\Enums\EstadoSolicitud;
use App\Enums\Rol;
use App\Enums\TipoViaje;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Viaje;
use App\Notifications\PagoProcesadoNotification;
use App\Notifications\SolicitudConfirmadaNotification;
use Database\Seeders\UserSeeder;
use Database\Seeders\ViajeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlataformaViajesTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_registro_guarda_el_rol_elegido(): void
    {
        $response = $this->post('/register', [
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rol' => Rol::Viajero->value,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'ana@example.com',
            'rol' => Rol::Viajero->value,
        ]);
    }

    public function test_no_se_puede_registrar_un_producto_con_mas_de_tres_unidades(): void
    {
        Storage::fake(config('filesystems.default'));

        $viajero = User::factory()->viajero()->create();
        $viaje = Viaje::factory()->create(['viajero_id' => $viajero->id]);

        $response = $this->actingAs($viajero)->post(route('productos.store'), [
            'viaje_id' => $viaje->id,
            'nombre' => 'Perfume',
            'descripcion' => 'Edición limitada',
            'precio' => 50,
            'fee_transporte' => 10,
            'cantidad_max' => 4,
            'imagen' => UploadedFile::fake()->image('perfume.jpg'),
        ]);

        $response->assertSessionHasErrors('cantidad_max');
        $this->assertDatabaseCount('productos', 0);
    }

    public function test_el_viajero_confirma_y_el_comprador_paga_con_notificacion(): void
    {
        Notification::fake();

        $viajero = User::factory()->viajero()->create();
        $comprador = User::factory()->comprador()->create();
        $viaje = Viaje::factory()->create(['viajero_id' => $viajero->id]);
        $producto = Producto::factory()->create([
            'viajero_id' => $viajero->id,
            'viaje_id' => $viaje->id,
            'precio' => 40,
            'fee_transporte' => 10,
            'cantidad_max' => 3,
            'cantidad_disponible' => 2,
        ]);
        $solicitud = Solicitud::factory()->create([
            'comprador_id' => $comprador->id,
            'producto_id' => $producto->id,
            'cantidad' => 1,
            'estado' => EstadoSolicitud::Pendiente,
        ]);

        $this->actingAs($viajero)
            ->patch(route('solicitudes.confirmar', $solicitud))
            ->assertRedirect();

        $solicitud->refresh();
        $this->assertSame(EstadoSolicitud::Confirmada, $solicitud->estado);
        Notification::assertSentTo($comprador, SolicitudConfirmadaNotification::class);

        $this->actingAs($comprador)
            ->post(route('pagos.store', $solicitud))
            ->assertRedirect(route('pedidos.show', $solicitud));

        $solicitud->refresh();
        $this->assertSame(EstadoSolicitud::Pagada, $solicitud->estado);
        $this->assertDatabaseHas('pagos', [
            'solicitud_id' => $solicitud->id,
            'total' => 50,
            'estado' => EstadoPago::Procesado->value,
        ]);
        Notification::assertSentTo($comprador, PagoProcesadoNotification::class);
    }

    public function test_el_seeder_crea_muchos_tipos_de_viaje(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(ViajeSeeder::class);

        $this->assertGreaterThanOrEqual(50, Viaje::query()->count());
        $this->assertCount(
            count(TipoViaje::cases()),
            Viaje::query()->pluck('tipo')->unique(),
        );

        $this->get(route('catalogo.index'))
            ->assertOk()
            ->assertSee('Viajes disponibles')
            ->assertSee('Playa')
            ->assertSee('Compras');
    }
}
