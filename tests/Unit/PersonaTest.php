<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class PersonaTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;
    public function test_se_puede_ingresar_usuario(): void
    {
$entidad = entidad::create([
            'codigo' => '5678',
            'subSector' => 'Administracion de Salud',
            'nivelGobierno' => 'Nacional',
            'estado' => 'Activo',
            'fechaCreacion' => now()->toDateString(),
            'fechaActualizacion' => now()->toDateString(),
        ]);

        // Crear usuario
        $usuario = User::create([
            'idEntidad' => $entidad->idEntidad,
            'cedula' => '2100372289',
            'name' => 'Irvin',
            'apellidos' => 'Celi',
            'rol' => 'Usuario Externo',
            'estado' => 'Activo',
            'email' => 'ioceli@utpl.edu.ec',
            'email_verified_at' => now(),
            'genero' => 'Masculino',
            'telefono' => '0986814308',
            'password' => Hash::make('Irvin1234'),
        ]);


       $this->assertDatabaseHas('users', [
            'cedula' => '2100372289',
            'email' => 'ioceli@utpl.edu.ec',
            'rol' => 'Usuario Externo',
        ]);
    }
}
