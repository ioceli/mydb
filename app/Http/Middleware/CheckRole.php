<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\RolEnum;
use Symfony\Component\HttpFoundation\Response;
class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        //Permitir Administrador del Sistema el acceso a todas las rutas
        if ($user->rol === RolEnum::admin->value) {
            return $next($request);
        }
        // Verificar si el usuario tiene alguno de los roles requeridos
        foreach ($roles as $role) {
            if ($user->rol === $role) {
                return $next($request);
            }
        }
        //MOSTRARA ERROR 403 EN LUGAR DE REDIRIGIR
        abort(403, 'No tienes permiso para acceder a esta página.');

    }
}