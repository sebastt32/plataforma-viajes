<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'monto_producto' => (float) $this->monto_producto,
            'fee_transporte' => (float) $this->fee_transporte,
            'total' => (float) $this->total,
            'estado' => $this->estado?->value,
            'estado_etiqueta' => $this->estado?->etiqueta(),
            'referencia' => $this->referencia,
            'notificado_en' => $this->notificado_en?->toIso8601String(),
        ];
    }
}
