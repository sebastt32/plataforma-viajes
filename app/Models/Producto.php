<?php

namespace App\Models;

use Database\Factories\ProductoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'viajero_id',
    'viaje_id',
    'nombre',
    'descripcion',
    'precio',
    'fee_transporte',
    'cantidad_max',
    'cantidad_disponible',
    'imagen_path',
    'imagen_externa_url',
])]
class Producto extends Model
{
    /** @use HasFactory<ProductoFactory> */
    use HasFactory;

    public const CANTIDAD_MAXIMA_PERMITIDA = 3;

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'fee_transporte' => 'decimal:2',
            'cantidad_max' => 'integer',
            'cantidad_disponible' => 'integer',
        ];
    }

    public function viajero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'viajero_id');
    }

    public function viaje(): BelongsTo
    {
        return $this->belongsTo(Viaje::class);
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class);
    }

    public function imagenUrl(): ?string
    {
        if ($this->imagen_path) {
            return Storage::disk(config('filesystems.default'))->url($this->imagen_path);
        }

        return $this->imagen_externa_url;
    }
}
