<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Programa;
use App\Models\User;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProgramaEditarTest extends TestCase
{
use RefreshDatabase;
    public function test_usuario_puede_editar_un_programa(): void
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

        // Crear programa original
        $programa = Programa::create([
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Programa Inicial',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);
        // Crear y autenticar usuario
        $usuario = User::factory()->create();
        $this->actingAs($usuario);
        // Ejecutar solicitud PUT para editar el programa
        $response = $this->put(route('programa.update', $programa->idPrograma), [
            'idEntidad' => $entidad->idEntidad,
            'nombre' => 'Programa Actualizado',
            'estado_revision' => 'pendiente',
            'fechaCreacion' => $programa->fechaCreacion,
            'fechaActualizacion' => now()->toDateString(),
        ]);
        // Verifica que se redirige correctamente
        $response->assertRedirect(route('programa.index'));
        // Verifica que los datos fueron actualizados en la base de datos
        $this->assertDatabaseHas('programa', [
            'idPrograma' => $programa->idPrograma,
            'nombre' => 'Programa Actualizado',
            'estado_revision' => 'pendiente',
        ]);
    }
}
