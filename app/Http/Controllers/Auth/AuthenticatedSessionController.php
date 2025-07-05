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

    $request->session()->regenerate();

    $rol = Auth::user()->rol;

    // Redirección basada en el rol
    return match ($rol) {
        'Administrador del Sistema'    => redirect()->route('dashboard.admin'),
        'Técnico de Planificación'     => redirect()->route('dashboard.tecnico'),
        'Revisor Institucional'        => redirect()->route('dashboard.revisor'),
        'Autoridad Validante'          => redirect()->route('dashboard.autoridad'),
        'Usuario Externo'              => redirect()->route('dashboard.externo'),
        'Auditor'                      => redirect()->route('dashboard.auditor'),
        'Desarrollador'                => redirect()->route('dashboard.desarrollador'),
        default                        => redirect()->route('dashboard'),
    };
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
