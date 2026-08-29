<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitudResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cantidad' => $this->cantidad,
            'estado' => $this->estado?->value,
            'estado_etiqueta' => $this->estado?->etiqueta(),
            'estado_color' => $this->estado?->color(),
            'producto' => $this->whenLoaded('producto', fn () => (new ProductoResource($this->producto))->resolve()),
            'comprador' => $this->whenLoaded('comprador', fn () => [
                'id' => $this->comprador->id,
                'name' => $this->comprador->name,
                'email' => $this->comprador->email,
            ]),
            'pago' => $this->whenLoaded('pago', fn () => (new PagoResource($this->pago))->resolve()),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
