<?php
namespace App\Http\Controllers\Auth;
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
        'two_factor_code' => 'required|string|digits:6',
    ]);
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }
    // Verificar código
    if (
        $user->two_factor_code === $request->two_factor_code &&
        $user->two_factor_expires_at &&
        $user->two_factor_expires_at->isFuture()
    ) {
        // Código válido - Resetear
        $user->resetTwoFactorCode();
        // Marcar 2FA como pasado en la sesión
        session()->put('two_factor:' . $user->id, true);
        // Regenerar sesión por seguridad
        $request->session()->regenerate();
        // Redirigir según rol
        return match ($user->rol) {
            'Administrador del Sistema' => redirect()->route('dashboard.admin'),
            'Técnico de Planificación' => redirect()->route('dashboard.tecnico'),
            'Revisor Institucional'    => redirect()->route('dashboard.revisor'),
            'Autoridad Validante'      => redirect()->route('dashboard.autoridad'),
            'Usuario Externo'          => redirect()->route('dashboard.externo'),
            'Auditor'                  => redirect()->route('dashboard.auditor'),
            default                    => redirect()->route('dashboard'),
        };
    }
    return back()->withErrors([
        'two_factor_code' => 'El código es inválido o ha expirado.'
    ]);
}
}