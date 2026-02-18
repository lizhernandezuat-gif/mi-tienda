<?php

namespace Database\Seeders;

use App\Models\Veterinaria;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Mascota;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Crear veterinaria
        $vet = Veterinaria::create([
            'nombre' => 'Patitas Cuidandote',
            'ciudad' => 'CDMX',
        ]);

        // Crear usuario (veterinario)
        $user = User::create([
            'name' => 'Dr. Veterinario',
            'email' => 'vet@example.com',
            'password' => bcrypt('password'),
            'veterinaria_id' => $vet->id,
            'configuracion' => json_encode(['max_mascotas' => 5]),
        ]);

        // Crear clientes
        $cliente = Cliente::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '1234567890',
            'veterinaria_id' => $vet->id,
        ]);

        // Crear mascotas
        Mascota::create([
            'nombre' => 'Max',
            'especie' => 'Perro',
            'raza' => 'Labrador',
            'cliente_id' => $cliente->id,
            'veterinaria_id' => $vet->id,
        ]);

        Mascota::create([
            'nombre' => 'Miau',
            'especie' => 'Gato',
            'raza' => 'Persa',
            'cliente_id' => $cliente->id,
            'veterinaria_id' => $vet->id,
        ]);
    }
}