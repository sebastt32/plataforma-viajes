<?php

namespace App\Models;

use App\Enums\EstadoPago;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'solicitud_id',
    'monto_producto',
    'fee_transporte',
    'total',
    'estado',
    'referencia',
    'notificado_en',
])]
class Pago extends Model
{
    protected function casts(): array
    {
        return [
            'monto_producto' => 'decimal:2',
            'fee_transporte' => 'decimal:2',
            'total' => 'decimal:2',
            'estado' => EstadoPago::class,
            'notificado_en' => 'datetime',
        ];
    }

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }
}
