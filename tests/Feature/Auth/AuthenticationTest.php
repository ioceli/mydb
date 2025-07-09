<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
         Session::start();
        $user = User::factory()->create([
  'password' => Hash::make('password'), ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard.externo'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        Session::start();
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
             '_token' => csrf_token(),
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
         Session::start();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout',[
               '_token' => csrf_token(),
        ]);
        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
