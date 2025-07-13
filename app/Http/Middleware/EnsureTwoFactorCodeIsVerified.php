<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Si no hay usuario logueado, redirige al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si el usuario ya completó MFA, continúa
        if (session()->get('two_factor:' . Auth::id())) {
            return $next($request);
        }

        // Si no ha pasado MFA, redirige al challenge
        return redirect()->route('two-factor.challenge');
    }
}