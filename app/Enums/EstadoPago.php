<?php

namespace App\Enums;

enum EstadoPago: string
{
    case Pendiente = 'pendiente';
    case Procesado = 'procesado';
    case Fallido = 'fallido';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Pendiente => 'Pendiente',
            self::Procesado => 'Procesado',
            self::Fallido => 'Fallido',
        };
    }
}
