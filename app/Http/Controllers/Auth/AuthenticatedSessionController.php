<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
  /** @var \App\Models\User $user */
    // Usuario autenticado
    $user = Auth::user();

    // Generar código MFA y enviarlo por correo
    $user->generateTwoFactorCode();

  // Volver a autenticar al usuario para mantener la sesión activa
    Auth::login($user);

       // Marcar como no verificado aún con MFA
    $request->session()->put('two_factor:' . $user->idUser, false);

 
    // Redirigir al formulario MFA
    return redirect()->route('two-factor.challenge');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
