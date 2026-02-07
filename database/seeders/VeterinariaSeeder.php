<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Veterinaria;
use App\Models\Cliente;

class VeterinariaSeeder extends Seeder
{
    public function run()
    {
        $central = Veterinaria::firstOrCreate([
            'nombre' => 'Central'
        ],[
            'direccion' => 'Sucursal Central',
            'telefono' => null,
            'activo' => true,
        ]);

        // Crear algunos clientes de ejemplo si no existen
        if (Cliente::count() < 5) {
            Cliente::factory()->count(10)->for($central)->create();
        }
    }
}
