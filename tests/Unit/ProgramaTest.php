<?php

namespace Tests\Unit;
use App\Models\Programa;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramaTest extends TestCase
{
use RefreshDatabase;
    public function test_puede_crear_un_programa(): void
    {
      $entidad = entidad::create([
            'codigo' => '1234',
            'subSector' => 'Agua Potable',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $programa = Programa::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Nuevo Programa',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
            ]);

        $this->assertDatabaseHas('programa', [
            'nombre' => 'Nuevo Programa',
            'estado_revision' => 'pendiente',
        ]);
        }
}
