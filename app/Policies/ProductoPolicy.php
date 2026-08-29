<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->esViajero();
    }

    public function view(User $user, Producto $producto): bool
    {
        return $user->esViajero() && $producto->viajero_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->esViajero();
    }

    public function update(User $user, Producto $producto): bool
    {
        return $this->view($user, $producto);
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $this->view($user, $producto);
    }
}
