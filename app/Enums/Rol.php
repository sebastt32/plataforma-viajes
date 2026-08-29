<?php

namespace App\Enums;

enum Rol: string
{
    case Viajero = 'viajero';
    case Comprador = 'comprador';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Viajero => 'Viajero',
            self::Comprador => 'Comprador',
        };
    }
}
