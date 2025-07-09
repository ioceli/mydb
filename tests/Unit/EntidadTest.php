<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entidad;

use Illuminate\Foundation\Testing\RefreshDatabase;

class EntidadTest extends TestCase
{
    use RefreshDatabase;


    public function test_puede_crearse_una_entidad()
    {
        $entidad = Entidad::create([
            'codigo' => '1012',
            'subSector' => 'Administracion Deporte',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('entidad', [
            'codigo' => '1012',
            'estado' => 'Activo'
        ]);
    }
}
