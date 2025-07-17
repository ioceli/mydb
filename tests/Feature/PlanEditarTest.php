<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Plan;
use App\Models\User;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanEditarTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_editar_un_plan(): void
    {
        // Crear entidad relacionada
        $entidad = Entidad::create([
            'codigo' => '4567',
            'subSector' => 'Transporte y Obras Públicas',
            'nivelGobierno' => 'Provincial',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Crear plan original
        $plan = Plan::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Plan Inicial',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Crear y autenticar usuario
        $usuario = User::factory()->create();
        $this->actingAs($usuario);

        // Ejecutar solicitud PUT para editar el plan
        $response = $this->put(route('plan.update', $plan->idPlan), [
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Plan Actualizado',
            'estado' => 'Inactivo',
            'fechaCreacion' => $plan->fechaCreacion,
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Verifica que se redirige correctamente
        $response->assertRedirect(route('plan.index'));

        // Verifica que los datos fueron actualizados en la base de datos
        $this->assertDatabaseHas('plan', [
            'idPlan' => $plan->idPlan,
            'nombre' => 'Plan Actualizado',
            'estado' => 'Inactivo',
        ]);
    }
}
