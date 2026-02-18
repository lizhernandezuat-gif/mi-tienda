<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Mascota;
use Faker\Factory as Faker;

class CargaMasivaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Tu ID de veterinaria (Usuario principal)
        $vetId = 1; 

        $this->command->info("Iniciando carga masiva...");

        for ($i = 0; $i < 1000; $i++) {
            
            $cliente = Cliente::create([
                'veterinaria_id' => $vetId,
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'telefono' => $faker->phoneNumber,
                // ¡AQUÍ YA NO HAY DIRECCIÓN! SE ELIMINÓ POR COMPLETO.
            ]);

            // Crear entre 3 y 5 mascotas por cliente
            $numMascotas = rand(3, 5);

            for ($j = 0; $j < $numMascotas; $j++) {
                Mascota::create([
                    'veterinaria_id' => $vetId,
                    'cliente_id' => $cliente->id,
                    'nombre' => $faker->firstName,
                    'especie' => $faker->randomElement(['Perro', 'Gato', 'Hamster', 'Ave']),
                    'raza' => $faker->word,
                    'edad' => rand(1, 15),
                    'peso' => $faker->randomFloat(1, 1, 40) . ' kg',
                    'foto' => null,
                ]);
            }
        }

        $this->command->info("✅ ¡ÉXITO! 1000 clientes creados correctamente.");
    }
}