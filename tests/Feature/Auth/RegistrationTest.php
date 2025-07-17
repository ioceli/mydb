<?php

namespace Tests\Feature\Auth;
use App\Enums\EstadoEnum;
use App\Enums\GeneroEnum;
use App\Enums\RolEnum;
use App\Models\Entidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
              $entidad = Entidad::factory()->create();
           $response = $this->post('/register', [
            'idEntidad' => $entidad->idEntidad,
            'cedula' => '0123456789',
            'name' => 'Test User',
            'apellidos' => 'Apellido Ejemplo',
            'rol' => RolEnum::values()[0], 
            'estado' => EstadoEnum::values()[0],
            'email' => 'test@example.com',
            'genero' => GeneroEnum::values()[0],
            'telefono' => '0987654321',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

         $response->assertRedirect(route('two-factor.challenge'));
        
              $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'cedula' => '0123456789',
        ]);
    }
    public function test_user_cannot_register_with_invalid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
