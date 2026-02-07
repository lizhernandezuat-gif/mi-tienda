<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureVeterinariaExists
{
    public function handle(Request $request, Closure $next)
    {
        if (! Schema::hasTable('veterinarias')) {
            return redirect()->route('veterinarias.create')->with('warning', 'Primero crea una sucursal (veterinaria) antes de gestionar clientes.');
        }

        $count = DB::table('veterinarias')->count();
        if ($count === 0) {
            return redirect()->route('veterinarias.create')->with('warning', 'Primero crea una sucursal (veterinaria) antes de gestionar clientes.');
        }

        return $next($request);
    }
}
