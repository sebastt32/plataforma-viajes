<?php

namespace App\Policies;

use App\Models\Solicitud;
use App\Models\User;

class SolicitudPolicy
{
    public function view(User $user, Solicitud $solicitud): bool
    {
        return $solicitud->comprador_id === $user->id
            || $solicitud->producto->viajero_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->esComprador();
    }

    public function confirmar(User $user, Solicitud $solicitud): bool
    {
        return $user->esViajero() && $solicitud->producto->viajero_id === $user->id;
    }

    public function pagar(User $user, Solicitud $solicitud): bool
    {
        return $user->esComprador() && $solicitud->comprador_id === $user->id;
    }
}
