<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
            'domicilio' => fake()->address(),
            
            // AGREGA ESTA LÍNEA PARA CALMAR EL ERROR:
            'mascota' => 'Ver tabla mascotas', 
            
            // 'veterinaria_id' se llena automático
        ];
    }
}