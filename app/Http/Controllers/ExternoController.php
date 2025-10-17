<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
use App\Models\Programa;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
class ExternoController extends Controller
{
    public function index()
    {
        // 1. OBTENER EL ID DE LA ENTIDAD DEL USUARIO AUTENTICADO
                $idEntidad = Auth::user()->idEntidad;
        // Si el usuario no tiene entidad asignada, retornar cero o manejar el error
        if (is_null($idEntidad)) {
            // Se puede retornar cero en todos los conteos si no hay entidad.
             $ceroData = [
                'totalPlanes' => 0, 'totalProgramas' => 0, 'totalProyectos' => 0,
                'planesPendientesRevisor' => 0, 'programasPendientesRevisor' => 0,
                'proyectosPendientesRevisor' => 0, 'planesPendientesAutoridad' => 0,
                'programasPendientesAutoridad' => 0, 'proyectosPendientesAutoridad' => 0,
            ];
             return view('dashboard.externo', $ceroData);
        }   
        $entidadColumn = 'idEntidad'; // Columna de filtro
        // 2. TOTALES: Filtrar por la Entidad del usuario
        $totalPlanes = Plan::where($entidadColumn, $idEntidad)->count();
        $totalProgramas = Programa::where($entidadColumn, $idEntidad)->count();
        $totalProyectos = Proyecto::where($entidadColumn, $idEntidad)->count();
        // 3. PENDIENTES REVISOR: Filtrar por Entidad Y Estado de Revisión
        $planesPendientesRevisor = Plan::where($entidadColumn, $idEntidad)
                                       ->where('estado_revision', EstadoRevisionEnum::pendiente)->count();     
        $programasPendientesRevisor = Programa::where($entidadColumn, $idEntidad)
                                              ->where('estado_revision', EstadoRevisionEnum::pendiente)->count();
        $proyectosPendientesRevisor = Proyecto::where($entidadColumn, $idEntidad)
                                              ->where('estado_revision', EstadoRevisionEnum::pendiente)->count();
        // 4. PENDIENTES AUTORIDAD: Filtrar por Entidad Y Estado de Autoridad
        $planesPendientesAutoridad = Plan::where($entidadColumn, $idEntidad)
                                         ->where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();
        $programasPendientesAutoridad = Programa::where($entidadColumn, $idEntidad)
                                                ->where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();
        $proyectosPendientesAutoridad = Proyecto::where($entidadColumn, $idEntidad)
                                                ->where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();
        return view('dashboard.externo', [
            'totalPlanes' => $totalPlanes,
            'totalProgramas' => $totalProgramas,
            'totalProyectos' => $totalProyectos,
            'planesPendientesRevisor' => $planesPendientesRevisor,
            'programasPendientesRevisor' => $programasPendientesRevisor,
            'proyectosPendientesRevisor' => $proyectosPendientesRevisor,
            'planesPendientesAutoridad' => $planesPendientesAutoridad,
            'programasPendientesAutoridad' => $programasPendientesAutoridad,
            'proyectosPendientesAutoridad' => $proyectosPendientesAutoridad,
        ]);
    }
}