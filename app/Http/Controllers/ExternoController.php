<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
use App\Models\Programa;
use App\Models\Proyecto;
class ExternoController extends Controller
{
    public function index()
    {
        $totalPlanes = Plan::count();
        $totalProgramas = Programa::count();
        $totalProyectos = Proyecto::count();
        $planesPendientesRevisor = Plan::where('estado_revision', EstadoRevisionEnum::pendiente)->count();
        $programasPendientesRevisor = Programa::where('estado_revision', EstadoRevisionEnum::pendiente)->count();
        $proyectosPendientesRevisor = Proyecto::where('estado_revision', EstadoRevisionEnum::pendiente)->count();
        $planesPendientesAutoridad = Plan::where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();
        $programasPendientesAutoridad = Programa::where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();
        $proyectosPendientesAutoridad = Proyecto::where('estado_autoridad', EstadoAutoridadEnum::pendiente)->count();

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