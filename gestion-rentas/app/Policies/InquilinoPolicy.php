<?php

namespace App\Policies;

use App\Models\Inquilino;
use App\Models\Propiedad;
use App\Models\User;

class InquilinoPolicy
{
    /**
     * Determine whether the user can view the inquilino.
     */
    public function view(User $user, Inquilino $inquilino): bool
    {
        // El usuario debe ser propietario de la propiedad del inquilino
        return $user->id === $inquilino->propiedad->user_id;
    }

    /**
     * Determine whether the user can create an inquilino.
     */
    public function create(User $user, Propiedad $propiedad): bool
    {
        // El usuario debe ser propietario de la propiedad
        return $user->id === $propiedad->user_id;
    }

    /**
     * Determine whether the user can update the inquilino.
     */
    public function update(User $user, Inquilino $inquilino): bool
    {
        // El usuario debe ser propietario de la propiedad del inquilino
        return $user->id === $inquilino->propiedad->user_id;
    }

    /**
     * Determine whether the user can delete the inquilino.
     */
    public function delete(User $user, Inquilino $inquilino): bool
    {
        // El usuario debe ser propietario de la propiedad del inquilino
        return $user->id === $inquilino->propiedad->user_id;
    }
}
