<?php

namespace App\Models;

use App\Enums\EstadoSolicitud;
use Database\Factories\SolicitudFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['comprador_id', 'producto_id', 'cantidad', 'estado'])]
class Solicitud extends Model
{
    /** @use HasFactory<SolicitudFactory> */
    use HasFactory;

    protected $table = 'solicitudes';

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'estado' => EstadoSolicitud::class,
        ];
    }

    public function comprador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'comprador_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function pago(): HasOne
    {
        return $this->hasOne(Pago::class);
    }

    public function viajero(): User
    {
        return $this->producto->viajero;
    }
}
