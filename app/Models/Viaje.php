<?php

namespace App\Models;

use App\Enums\EstadoViaje;
use App\Enums\TipoViaje;
use Database\Factories\ViajeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['viajero_id', 'origen', 'destino', 'tipo', 'fecha_salida', 'notas', 'estado', 'imagen_path', 'imagen_externa_url'])]
class Viaje extends Model
{
    /** @use HasFactory<ViajeFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'fecha_salida' => 'date',
            'estado' => EstadoViaje::class,
            'tipo' => TipoViaje::class,
        ];
    }

    public function imagenUrl(): ?string
    {
        if ($this->imagen_path) {
            return Storage::disk(config('filesystems.default'))->url($this->imagen_path);
        }

        return $this->imagen_externa_url;
    }

    public function viajero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'viajero_id');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
