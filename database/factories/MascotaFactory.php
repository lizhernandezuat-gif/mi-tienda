<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MascotaFactory extends Factory
{
    public function definition(): array
    {
        // Listas de razas para que se vea real
        $especies = ['Perro', 'Gato'];
        $razasPerro = ['Labrador', 'Pug', 'Pastor Alemán', 'Husky', 'Chihuahua'];
        $razasGato = ['Persa', 'Siamés', 'Bengala', 'Sphynx', 'Mestizo'];
        
        $especie = fake()->randomElement($especies);
        $raza = ($especie === 'Perro') ? fake()->randomElement($razasPerro) : fake()->randomElement($razasGato);

        return [
            // AQUÍ SOLO DATOS DE LA MASCOTA
            'nombre' => fake()->firstName(), // Nombres tipo "Firulais"
            'especie' => $especie,
            'raza' => $raza,
            'edad' => fake()->numberBetween(1, 15),
            'peso' => fake()->randomFloat(2, 1, 40),
            // NO ponemos cliente_id aquí, se llena automático al relacionarlos
        ];
    }
}