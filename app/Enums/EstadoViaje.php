<?php

namespace App\Enums;

enum EstadoViaje: string
{
    case Publicado = 'publicado';
    case Cerrado = 'cerrado';
    case Cancelado = 'cancelado';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Publicado => 'Publicado',
            self::Cerrado => 'Cerrado',
            self::Cancelado => 'Cancelado',
        };
    }
}
