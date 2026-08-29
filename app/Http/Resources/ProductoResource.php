<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => (float) $this->precio,
            'fee_transporte' => (float) $this->fee_transporte,
            'cantidad_max' => $this->cantidad_max,
            'cantidad_disponible' => $this->cantidad_disponible,
            'imagen_url' => $this->imagenUrl(),
            'imagen_externa_url' => $this->imagen_externa_url,
            'viaje' => $this->whenLoaded('viaje', fn () => (new ViajeResource($this->viaje))->resolve()),
            'viajero' => $this->whenLoaded('viajero', fn () => [
                'id' => $this->viajero->id,
                'name' => $this->viajero->name,
            ]),
        ];
    }
}
