<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;

class ClientePolicy
{
    /**
     * Determinar si el usuario puede ver todos los clientes
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver sus clientes
        return true;
    }

    /**
     * Determinar si el usuario puede ver un cliente específico
     */
    public function view(User $user, Cliente $cliente): bool
    {
        // El usuario solo puede ver clientes de SU veterinaria
        return $user->veterinaria_id === $cliente->veterinaria_id;
    }

    /**
     * Determinar si el usuario puede crear clientes
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede actualizar un cliente
     */
    public function update(User $user, Cliente $cliente): bool
    {
        // El usuario solo puede editar clientes de SU veterinaria
        return $user->veterinaria_id === $cliente->veterinaria_id;
    }

    /**
     * Determinar si el usuario puede eliminar un cliente
     */
    public function delete(User $user, Cliente $cliente): bool
    {
        // El usuario solo puede eliminar clientes de SU veterinaria
        return $user->veterinaria_id === $cliente->veterinaria_id;
    }

    /**
     * Determinar si el usuario puede restaurar un cliente eliminado
     */
    public function restore(User $user, Cliente $cliente): bool
    {
        return $user->veterinaria_id === $cliente->veterinaria_id;
    }

    /**
     * Determinar si el usuario puede eliminar permanentemente un cliente
     */
    public function forceDelete(User $user, Cliente $cliente): bool
    {
        return $user->veterinaria_id === $cliente->veterinaria_id;
    }
}