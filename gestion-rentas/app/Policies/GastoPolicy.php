<?php

namespace App\Policies;

use App\Models\Gasto;
use App\Models\Propiedad;
use App\Models\User;

class GastoPolicy
{
    /**
     * Determine whether the user can view any gastos.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the gasto.
     */
    public function view(User $user, Gasto $gasto): bool
    {
        return $gasto->propiedad && $gasto->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can create gastos for a propiedad.
     */
    public function create(User $user, Propiedad $propiedad): bool
    {
        return $propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the gasto.
     */
    public function update(User $user, Gasto $gasto): bool
    {
        return $gasto->propiedad && $gasto->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the gasto.
     */
    public function delete(User $user, Gasto $gasto): bool
    {
        return $gasto->propiedad && $gasto->propiedad->user_id === $user->id;
    }
}
