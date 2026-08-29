<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Viaje;

class ViajePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->esViajero();
    }

    public function view(User $user, Viaje $viaje): bool
    {
        return $user->esViajero() && $viaje->viajero_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->esViajero();
    }

    public function update(User $user, Viaje $viaje): bool
    {
        return $this->view($user, $viaje);
    }

    public function delete(User $user, Viaje $viaje): bool
    {
        return $this->view($user, $viaje);
    }
}
