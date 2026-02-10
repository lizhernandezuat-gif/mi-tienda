<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Veterinaria;
use App\Models\Cliente;
use App\Models\Mascota;

class CargaMasivaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buscamos tu veterinaria "DogCat" (o la primera que encuentre)
        $miVeterinaria = Veterinaria::first();

        if (!$miVeterinaria) {
            $this->command->error('¡No encontré ninguna veterinaria! Crea una primero.');
            return;
        }

        $this->command->info("Iniciando carga masiva para: " . $miVeterinaria->nombre_veterinaria);

        // 2. Aquí ocurre la MAGIA:
        // Crea 1000 Clientes...
        // Y por cada uno, crea entre 3 y 10 Mascotas (has Mascota...)
        Cliente::factory()
            ->count(1000) 
            ->has(
                Mascota::factory()->count(rand(3, 10))
            )
            ->create([
                'veterinaria_id' => $miVeterinaria->id // Los vinculamos a TU clínica
            ]);

        $this->command->info("¡Éxito! Se crearon 1,000 clientes y miles de mascotas.");
    }
}