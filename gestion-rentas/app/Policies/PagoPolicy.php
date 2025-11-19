<?php

namespace App\Policies;

use App\Models\Pago;
use App\Models\Propiedad;
use App\Models\User;

class PagoPolicy
{
    /**
     * Determine whether the user can view any pagos.
     */
    public function viewAny(User $user): bool
    {
        // Permitir ver la lista; el controlador filtrará por propiedades del usuario
        return true;
    }

    /**
     * Determine whether the user can view the pago.
     */
    public function view(User $user, Pago $pago): bool
    {
        return $pago->propiedad && $pago->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can create pagos for a propiedad.
     */
    public function create(User $user, Propiedad $propiedad): bool
    {
        return $propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the pago.
     */
    public function update(User $user, Pago $pago): bool
    {
        return $pago->propiedad && $pago->propiedad->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the pago.
     */
    public function delete(User $user, Pago $pago): bool
    {
        return $pago->propiedad && $pago->propiedad->user_id === $user->id;
    }
}
