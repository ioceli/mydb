<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TwoFactorVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        // Si no hay usuario, continuar
        if (!$user) {
            return $next($request);
        }
        // Rutas excluidas (no requieren 2FA)
        $excludedRoutes = [
            'two-factor.challenge',
            'two-factor.verify', 
            'logout',
        ];
        // Si estamos en una ruta excluida, permitir acceso
        foreach ($excludedRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }
        // Verificar si ya pasó 2FA en esta sesión
        if (session()->get('two_factor:' . $user->id)) {
            return $next($request);
        }
        // Si no ha pasado 2FA, redirigir
        return redirect()->route('two-factor.challenge');
    }
}