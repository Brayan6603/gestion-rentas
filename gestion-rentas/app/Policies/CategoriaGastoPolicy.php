<?php

namespace App\Policies;

use App\Models\CategoriaGasto;
use App\Models\User;

class CategoriaGastoPolicy
{
    /**
     * Determine whether the user can view any categorias.
     */
    public function viewAny(User $user): bool
    {
        // Las categorías son globales, todos pueden verlas
        return true;
    }

    /**
     * Determine whether the user can view the categoria.
     */
    public function view(User $user, CategoriaGasto $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create categorias.
     */
    public function create(User $user): bool
    {
        // Solo administradores pueden crear categorías
        return $user->role === 'admin' || !$user->role; // Asumo que solo ciertos usuarios pueden crear
        // Si no hay roles, permitir que cualquiera autenticado cree
        return true;
    }

    /**
     * Determine whether the user can update the categoria.
     */
    public function update(User $user, CategoriaGasto $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the categoria.
     */
    public function delete(User $user, CategoriaGasto $categoria): bool
    {
        return true;
    }
}
