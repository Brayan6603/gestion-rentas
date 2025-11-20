<?php

namespace App\Policies;

use App\Models\Deposito;
use App\Models\Propiedad;
use App\Models\User;

class DepositoPolicy
{
    /**
     * Determine whether the user can view any depositos.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the deposito.
     */
    public function view(User $user, Deposito $deposito): bool
    {
        return $deposito->propiedad && $deposito->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can create depositos for a propiedad.
     */
    public function create(User $user, Propiedad $propiedad): bool
    {
        return $propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the deposito.
     */
    public function update(User $user, Deposito $deposito): bool
    {
        return $deposito->propiedad && $deposito->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the deposito.
     */
    public function delete(User $user, Deposito $deposito): bool
    {
        return $deposito->propiedad && $deposito->propiedad->user_id === $user->id;
    }
}
