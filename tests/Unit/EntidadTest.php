<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entidad;
/* use App\Models\Proyecto; */
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntidadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
   /*  public function tiene_campos_fillable_correctos()
    {
        $entidad = new Entidad();

        $this->assertEquals(['nombre', 'tipo', 'estado'], $entidad->getFillable());
    } */

    /** @test */
   /*  public function puede_tener_muchos_proyectos()
    {
        $entidad = Entidad::factory()->create();
        $proyecto = Proyecto::factory()->create(['entidad_id' => $entidad->id]);

        $this->assertTrue($entidad->proyectos->contains($proyecto));
    } */

    /** @test */
    public function puede_crearse_una_entidad()
    {
        $entidad = Entidad::create([
            'codigo' => '1012',
            'subSector' => 'Administracion Deporte',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('entidads', [
            'codigo' => '1012',
            'estado' => 'Activo'
        ]);
    }
}
