<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Veterinaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->optional()->safeEmail,
            'telefono' => $this->faker->unique()->e164PhoneNumber,
            'telefono_alterno' => $this->faker->optional()->e164PhoneNumber,
            'nombre_mascota' => $this->faker->firstName,
            'tipo_mascota' => $this->faker->randomElement(['Perro','Gato','Ave','Otro']),
            'raza_mascota' => $this->faker->word,
            'edad_mascota' => $this->faker->numberBetween(1,15),
            'domicilio' => $this->faker->address,
            'fecha_nacimiento' => $this->faker->optional()->date(),
            'preferencia_contacto' => $this->faker->randomElement(['telefono','email']),
            'contacto_emergencia' => $this->faker->optional()->phoneNumber,
            'activo' => true,
            'notas' => $this->faker->optional()->sentence,
            'veterinaria_id' => Veterinaria::factory(),
        ];
    }
}
