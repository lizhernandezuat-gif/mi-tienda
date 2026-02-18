<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VeterinariaScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder instance.
     * 
     * Este scope se aplica AUTOMÁTICAMENTE a TODAS las consultas
     * de los modelos que lo usen, filtrando por la veterinaria
     * del usuario autenticado.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // ✅ SI el usuario está autenticado, filtrar por su veterinaria
        if (Auth::check()) {
            $builder->where($model->getTable() . '.veterinaria_id', Auth::user()->veterinaria_id);
        }
    }
}