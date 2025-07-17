<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Entidad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntidadEditarTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_editar_una_entidad(): void
    {
        // Crear entidad original
        $entidad = Entidad::create([
            'codigo' => '2001',
            'subSector' => 'Finanzas Públicas',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Crear y autenticar un usuario (si es necesario para acceder a la ruta)
        $usuario = User::factory()->create();
        $this->actingAs($usuario);

        // Ejecutar solicitud PUT para actualizar la entidad
        $response = $this->put(route('entidad.update', $entidad->idEntidad), [
            'codigo' => '2001',
            'subSector' => 'Finanzas y Tesorería',
            'nivelGobierno' => 'Regional',
            'estado' => 'Inactivo',
            'fechaCreacion' => $entidad->fechaCreacion,
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Verificar redirección después de actualizar
        $response->assertRedirect(route('entidad.index'));

        // Verificar en base de datos que se actualizaron los valores
        $this->assertDatabaseHas('entidad', [
            'idEntidad' => $entidad->idEntidad,
            'subSector' => 'Finanzas y Tesorería',
            'nivelGobierno' => 'Regional',
            'estado' => 'Inactivo',
        ]);
    }
}