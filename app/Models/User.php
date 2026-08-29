<?php

namespace App\Models;

use App\Enums\Rol;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'rol'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'rol' => Rol::class,
        ];
    }

    public function esViajero(): bool
    {
        return $this->rol === Rol::Viajero;
    }

    public function esComprador(): bool
    {
        return $this->rol === Rol::Comprador;
    }

    public function viajes(): HasMany
    {
        return $this->hasMany(Viaje::class, 'viajero_id');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'viajero_id');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'comprador_id');
    }
}
