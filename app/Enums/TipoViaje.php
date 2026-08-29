<?php

namespace App\Enums;

enum TipoViaje: string
{
    case Playa = 'playa';
    case Aventura = 'aventura';
    case Cultural = 'cultural';
    case Negocios = 'negocios';
    case Familiar = 'familiar';
    case Romantico = 'romantico';
    case Mochilero = 'mochilero';
    case Naturaleza = 'naturaleza';
    case Gastronomico = 'gastronomico';
    case Compras = 'compras';
    case Estudio = 'estudio';
    case Crucero = 'crucero';
    case Urbano = 'urbano';
    case Nieve = 'nieve';
    case Bienestar = 'bienestar';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Playa => 'Playa',
            self::Aventura => 'Aventura',
            self::Cultural => 'Cultural',
            self::Negocios => 'Negocios',
            self::Familiar => 'Familiar',
            self::Romantico => 'Romántico',
            self::Mochilero => 'Mochilero',
            self::Naturaleza => 'Naturaleza',
            self::Gastronomico => 'Gastronómico',
            self::Compras => 'Compras',
            self::Estudio => 'Estudio',
            self::Crucero => 'Crucero',
            self::Urbano => 'Urbano',
            self::Nieve => 'Nieve',
            self::Bienestar => 'Bienestar',
        };
    }
}
