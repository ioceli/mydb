<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Plan;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanTest extends TestCase
{
  use RefreshDatabase;
    public function test_puede_crear_un_plan(): void
    {
         $entidad = entidad::create([
            'codigo' => '1234',
            'subSector' => 'Agua Potable',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $plan = Plan::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Nuevo Plan',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('plan', [
            'nombre' => 'Nuevo Plan',
            'estado' => 'Activo'
        ]);
    }
}
