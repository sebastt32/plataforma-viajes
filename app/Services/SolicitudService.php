<?php

namespace App\Services;

use App\Enums\EstadoSolicitud;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\User;
use App\Notifications\SolicitudConfirmadaNotification;
use App\Notifications\SolicitudRechazadaNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SolicitudService
{
    public function crear(User $comprador, Producto $producto, int $cantidad): Solicitud
    {
        if ($cantidad < 1 || $cantidad > $producto->cantidad_disponible) {
            throw ValidationException::withMessages([
                'cantidad' => 'No hay suficientes unidades disponibles.',
            ]);
        }

        if ($cantidad > Producto::CANTIDAD_MAXIMA_PERMITIDA) {
            throw ValidationException::withMessages([
                'cantidad' => 'No puedes solicitar más de '.Producto::CANTIDAD_MAXIMA_PERMITIDA.' unidades.',
            ]);
        }

        return DB::transaction(function () use ($comprador, $producto, $cantidad) {
            $producto = Producto::query()->lockForUpdate()->findOrFail($producto->id);

            if ($cantidad > $producto->cantidad_disponible) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No hay suficientes unidades disponibles.',
                ]);
            }

            $producto->decrement('cantidad_disponible', $cantidad);

            return $comprador->solicitudes()->create([
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'estado' => EstadoSolicitud::Pendiente,
            ]);
        });
    }

    public function confirmar(User $viajero, Solicitud $solicitud): Solicitud
    {
        $this->asegurarDueño($viajero, $solicitud);
        $this->asegurarEstado($solicitud, EstadoSolicitud::Pendiente);

        $solicitud->update(['estado' => EstadoSolicitud::Confirmada]);
        $solicitud->comprador->notify(new SolicitudConfirmadaNotification($solicitud->load('producto')));

        return $solicitud->refresh();
    }

    public function rechazar(User $viajero, Solicitud $solicitud): Solicitud
    {
        $this->asegurarDueño($viajero, $solicitud);
        $this->asegurarEstado($solicitud, EstadoSolicitud::Pendiente);

        return DB::transaction(function () use ($solicitud) {
            $solicitud->producto->increment('cantidad_disponible', $solicitud->cantidad);
            $solicitud->update(['estado' => EstadoSolicitud::Rechazada]);
            $solicitud->comprador->notify(new SolicitudRechazadaNotification($solicitud->load('producto')));

            return $solicitud->refresh();
        });
    }

    public function marcarEnCamino(User $viajero, Solicitud $solicitud): Solicitud
    {
        $this->asegurarDueño($viajero, $solicitud);
        $this->asegurarEstado($solicitud, EstadoSolicitud::Pagada);

        $solicitud->update(['estado' => EstadoSolicitud::EnCamino]);

        return $solicitud->refresh();
    }

    public function marcarEntregada(User $viajero, Solicitud $solicitud): Solicitud
    {
        $this->asegurarDueño($viajero, $solicitud);
        $this->asegurarEstado($solicitud, EstadoSolicitud::EnCamino);

        $solicitud->update(['estado' => EstadoSolicitud::Entregada]);

        return $solicitud->refresh();
    }

    public function bandejaViajero(User $viajero): Collection
    {
        return Solicitud::query()
            ->with(['producto.viaje', 'comprador', 'pago'])
            ->whereHas('producto', fn ($query) => $query->where('viajero_id', $viajero->id))
            ->latest()
            ->get();
    }

    public function pedidosComprador(User $comprador): Collection
    {
        return $comprador->solicitudes()
            ->with(['producto.viaje', 'pago'])
            ->latest()
            ->get();
    }

    private function asegurarDueño(User $viajero, Solicitud $solicitud): void
    {
        if ($solicitud->producto->viajero_id !== $viajero->id) {
            abort(403);
        }
    }

    private function asegurarEstado(Solicitud $solicitud, EstadoSolicitud $esperado): void
    {
        if ($solicitud->estado !== $esperado) {
            throw ValidationException::withMessages([
                'solicitud' => 'La solicitud no está en un estado válido para esta acción.',
            ]);
        }
    }
}
