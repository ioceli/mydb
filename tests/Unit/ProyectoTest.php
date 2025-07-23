<?php
namespace Tests\Unit;
use App\Models\Proyecto;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProyectoTest extends TestCase
{
use RefreshDatabase;
    public function test_puede_crear_un_proyecto(): void
    {
 $entidad = entidad::create([
            'codigo' => '1234',
            'subSector' => 'Agua Potable',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $proyecto = Proyecto::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Nuevo Proyecto',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
            ]);

        $this->assertDatabaseHas('proyecto', [
            'nombre' => 'Nuevo Proyecto',
            'estado_revision' => 'pendiente',
        ]);
    }
}
