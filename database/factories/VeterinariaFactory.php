<?php

namespace Database\Factories;

use App\Models\Veterinaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeterinariaFactory extends Factory
{
    protected $model = Veterinaria::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company . ' Vet',
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->e164PhoneNumber,
            'activo' => true,
        ];
    }
}
