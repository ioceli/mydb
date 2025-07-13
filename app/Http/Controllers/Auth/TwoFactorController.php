<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Enums\RolEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    // Mostrar formulario para ingresar el código MFA
    public function showChallengeForm()
    {


        return view('auth.two-factor-challenge');
    }

   // Verificar el código MFA ingresado
    public function verifyChallenge(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user || !$user->two_factor_code || !$user->two_factor_expires_at) {
            return back()->withErrors(['two_factor_code' => 'Código inválido.']);
        }

        if (
            $user->two_factor_code === $request->two_factor_code &&
            $user->two_factor_expires_at->isFuture()
        ) {
            // Código válido y no ha expirado Resetea el código MFA   
             $user->resetTwoFactorCode();  

            //  Marcar como verificado
            session()->put('two_factor:' . $user->id, true);

            $request->session()->regenerate();

            return match ($user->rol) {
               RolEnum::admin->value    => redirect()->route('dashboard.admin'),
    RolEnum::tecnico->value          => redirect()->route('dashboard.tecnico'),
    RolEnum::revisor->value          => redirect()->route('dashboard.revisor'),
    RolEnum::autoridad->value        => redirect()->route('dashboard.autoridad'),
    RolEnum::externo->value          => redirect()->route('dashboard.externo'),
    RolEnum::auditor->value          => redirect()->route('dashboard.auditor'),
    RolEnum::desarrollador->value    => redirect()->route('dashboard.desarrollador'),
    default                          => redirect()->route('dashboard'),
            };
        }

        return back()->withErrors(['two_factor_code' => 'El código es inválido o ha expirado.']);
    }

}