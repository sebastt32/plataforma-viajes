<?php

namespace Database\Seeders;

use App\Enums\TipoViaje;

class DemoImageUrls
{
    public static function viaje(string $origen, string $destino, TipoViaje $tipo): string
    {
        $temas = match ($tipo) {
            TipoViaje::Playa, TipoViaje::Crucero => ['beach', 'ocean', 'tropical', 'island'],
            TipoViaje::Aventura, TipoViaje::Naturaleza, TipoViaje::Nieve => ['mountain', 'forest', 'adventure', 'landscape'],
            TipoViaje::Urbano, TipoViaje::Negocios, TipoViaje::Compras, TipoViaje::Estudio => ['city', 'skyline', 'street', 'architecture'],
            TipoViaje::Cultural, TipoViaje::Gastronomico, TipoViaje::Romantico => ['culture', 'oldtown', 'landmark', 'travel'],
            TipoViaje::Familiar, TipoViaje::Bienestar, TipoViaje::Mochilero => ['travel', 'vacation', 'landscape', 'city'],
        };

        $tema = $temas[crc32($origen.$destino) % count($temas)];
        $seed = $tema.'-'.substr(md5($origen.'-'.$destino), 0, 10);

        return "https://picsum.photos/seed/{$seed}/800/600";
    }

    public static function producto(string $nombre): string
    {
        $seed = 'producto-'.substr(md5($nombre), 0, 12);

        return "https://picsum.photos/seed/{$seed}/600/600";
    }
}
