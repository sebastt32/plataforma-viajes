<?php

namespace App\Services;

use App\Enums\EstadoPago;
use App\Enums\EstadoSolicitud;
use App\Models\Pago;
use App\Models\Solicitud;
use App\Models\User;
use App\Notifications\PagoProcesadoNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PagoNotificacionService
{
    public function procesar(User $comprador, Solicitud $solicitud): Pago
    {
        if ($solicitud->comprador_id !== $comprador->id) {
            abort(403);
        }

        if ($solicitud->estado !== EstadoSolicitud::Confirmada) {
            throw ValidationException::withMessages([
                'pago' => 'La solicitud debe estar confirmada antes de pagar.',
            ]);
        }

        if ($solicitud->pago) {
            throw ValidationException::withMessages([
                'pago' => 'Esta solicitud ya tiene un pago registrado.',
            ]);
        }

        return DB::transaction(function () use ($solicitud) {
            $solicitud->load('producto', 'comprador');

            $montoProducto = (float) $solicitud->producto->precio * $solicitud->cantidad;
            $feeTransporte = (float) $solicitud->producto->fee_transporte * $solicitud->cantidad;

            $pago = Pago::query()->create([
                'solicitud_id' => $solicitud->id,
                'monto_producto' => $montoProducto,
                'fee_transporte' => $feeTransporte,
                'total' => $montoProducto + $feeTransporte,
                'estado' => EstadoPago::Procesado,
                'referencia' => 'PAY-'.Str::upper(Str::random(10)),
                'notificado_en' => now(),
            ]);

            $solicitud->update(['estado' => EstadoSolicitud::Pagada]);
            $solicitud->comprador->notify(new PagoProcesadoNotification($pago));

            return $pago;
        });
    }
}
