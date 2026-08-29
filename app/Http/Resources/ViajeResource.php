<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViajeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'origen' => $this->origen,
            'destino' => $this->destino,
            'tipo' => $this->tipo?->value,
            'tipo_etiqueta' => $this->tipo?->etiqueta(),
            'fecha_salida' => $this->fecha_salida?->toDateString(),
            'notas' => $this->notas,
            'imagen_url' => $this->imagenUrl(),
            'imagen_externa_url' => $this->imagen_externa_url,
            'estado' => $this->estado?->value,
            'estado_etiqueta' => $this->estado?->etiqueta(),
            'viajero' => $this->whenLoaded('viajero', fn () => [
                'id' => $this->viajero->id,
                'name' => $this->viajero->name,
            ]),
            'productos_count' => $this->whenCounted('productos'),
        ];
    }
}
