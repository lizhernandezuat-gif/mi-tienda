<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;

class ClienteUniquePhoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_create_two_clients_with_same_phone()
    {
        $telefono = '+1234567890';

        $vet = \App\Models\Veterinaria::factory()->create();

        Cliente::factory()->create(['telefono' => $telefono, 'veterinaria_id' => $vet->id]);

        $response = $this->post(route('clientes.store'), [
            'nombre' => 'Otro Cliente',
            'telefono' => $telefono,
            'nombre_mascota' => 'Pupi',
            'veterinaria_id' => $vet->id,
        ]);

        $response->assertSessionHasErrors('telefono');
    }
}
