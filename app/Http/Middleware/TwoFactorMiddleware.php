<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
       public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->two_factor_code && $user->two_factor_expires_at > now()) {
            // Si aún no ha ingresado su código MFA, redirige al formulario
            if (!$request->is('two-factor*')) {
                return redirect()->route('two-factor.challenge');
            }
        }

        return $next($request);
    }
}
