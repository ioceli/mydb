<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProyectoEditarTest extends TestCase
{
use RefreshDatabase;
    public function test_usuario_puede_editar_un_proyecto(): void
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
        // Crear proyecto original
        $proyecto = Proyecto::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Proyecto Inicial',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);
        // Crear y autenticar usuario
        $usuario = User::factory()->create();
        $this->actingAs($usuario);
        // Ejecutar solicitud PUT para editar el proyecto
        $response = $this->put(route('proyecto.update', $proyecto->idProyecto), [
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Proyecto Actualizado',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => $proyecto->fechaCreacion,
            'fechaActualizacion' => now()->toDateString(),
        ]);
        // Verifica que se redirige correctamente
        $response->assertRedirect(route('proyecto.index'));

        // Verifica que los datos fueron actualizados en la base de datos
        $this->assertDatabaseHas('proyecto', [
            'idProyecto' => $proyecto->idProyecto,
            'nombre' => 'Proyecto Actualizado',
            'estado_revision' => 'pendiente',
        ]);
    }
}
