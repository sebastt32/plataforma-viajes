<?php

namespace App\Enums;

enum EstadoSolicitud: string
{
    case Pendiente = 'pendiente';
    case Confirmada = 'confirmada';
    case Rechazada = 'rechazada';
    case Pagada = 'pagada';
    case EnCamino = 'en_camino';
    case Entregada = 'entregada';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Pendiente => 'Pendiente',
            self::Confirmada => 'Confirmada',
            self::Rechazada => 'Rechazada',
            self::Pagada => 'Pagada',
            self::EnCamino => 'En camino',
            self::Entregada => 'Entregada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pendiente => 'bg-accent-light text-accent-dark',
            self::Confirmada => 'bg-amber-50 text-amber-800',
            self::Rechazada => 'bg-red-50 text-red-700',
            self::Pagada => 'bg-warm-100 text-warm-800',
            self::EnCamino => 'bg-orange-50 text-orange-800',
            self::Entregada => 'bg-emerald-50 text-emerald-800',
        };
    }
}
