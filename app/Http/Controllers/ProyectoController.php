<?php
namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
use App\Helpers\BitacoraHelper;
use App\Models\metaEstrategica;
use App\Models\entidad;
use App\Models\proyecto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoRevisionEnum; 
use App\Enums\EstadoAutoridadEnum;
use Illuminate\Support\Facades\Auth;
class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
// 1. Obtener el ID de la Entidad del usuario logueado
        $idEntidad = Auth::user()->idEntidad; 
        // 2. Definir la consulta base filtrada por idEntidad
        $proyectosQuery = Proyecto::with(['entidad', 'objetivosEstrategicos', 'metasEstrategicas'])
                           ->where('idEntidad', $idEntidad);
        // 3. Obtener los resultados
        $proyecto = $proyectosQuery->get();
        // 4. Manejo de resultados (si no hay proyectos para esa entidad)
        if ($proyecto->isEmpty()) {
            return view('proyecto.index', ['proyecto' => $proyecto, 'message' => 'No hay proyectos registrados para su Entidad.']);
        }
        // 5. Retornar la vista con los proyectos filtrados
        return view('proyecto.index', compact('proyecto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entidad = entidad::all();
        $objetivoEstrategico = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();
       return view('proyecto.create', compact('entidad', 'objetivoEstrategico', 'metasEstrategicas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        BitacoraHelper::registrar('Proyecto', 'Creó un nuevo proyecto');
          $request->validate([
            'cup' => 'unique:proyecto,cup',
            'tipo_dictamen' => 'required|in:prioridad,aprobacion,actualizacion_prioridad,actualizacion_aprobacion',
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'accion' => 'required|string',
            'objeto' => 'required|string',
            'nombre'=>'required|string|max:255',
            'plazo_ejecucion' => 'required|string|max:50',
            'monto_total' => 'required|numeric|min:0',
            'diagnostico' => 'nullable|string',
            'problema' => 'nullable|string',
            'longitud' => 'nullable|numeric',
            'latitud' => 'nullable|numeric',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
            'componentesProyecto' => 'nullable|array',
            'componentesProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.descripcion' => 'nullable|string',
            'componentesProyecto.*.monto' => 'required|numeric',
            'componentesProyecto.*.actividadesProyecto' => 'nullable|array',
            'componentesProyecto.*.actividadesProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.actividadesProyecto.*.monto' => 'required|numeric',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto' => 'nullable|array',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto.*.monto' => 'required|numeric',
        ]);
       $proyecto = proyecto::create([
        'cup' => proyecto::generarCUP(),
        'idEntidad' => $request->idEntidad,
        'tipo_dictamen' => $request->tipo_dictamen,
        'accion' => $request->accion,
        'objeto' => $request->objeto,
        'nombre' => ucfirst($request->accion) . ' de ' . $request->objeto,
        'plazo_ejecucion' => $request->plazo_ejecucion,
        'monto_total' => $request->monto_total,
        'diagnostico' => $request->diagnostico,
        'problema' => $request->problema,
        'longitud' => $request->longitud,
        'latitud' => $request->latitud,
        'estado_revision' => 'pendiente',
        'estado_autoridad' => 'pendiente',
    ]);
        // Asocia objetivos estratégicos al proyecto
    if ($request->has('idObjetivoEstrategico')) {
        $proyecto->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
    }
    // Asocia metas estratégicas al proyecto
    if ($request->has('idMetaEstrategica')) {
        $proyecto->metasEstrategicas()->sync($request->idMetaEstrategica);
    }
    // Procesa los componentes, actividades y tareas
    if ($request->has('componentesProyecto')) {
        foreach ($request->input('componentesProyecto') as $compData) {
            $componenteProyecto = $proyecto->componentesProyecto()->create([
                'nombre' => $compData['nombre'],
                'descripcion' => $compData['descripcion'] ?? null,
                'monto' => $compData['monto'],
            ]);

            if (isset($compData['actividadesProyecto'])) {
                foreach ($compData['actividadesProyecto'] as $actData) {
                    $actividadProyecto = $componenteProyecto->actividadesProyecto()->create([
                        'nombre' => $actData['nombre'],
                        'monto' => $actData['monto'],
                    ]);

                    if (isset($actData['tareasProyecto'])) {
                        foreach ($actData['tareasProyecto'] as $tarData) {
                            $actividadProyecto->tareasProyecto()->create([
                                'nombre' => $tarData['nombre'],
                                'monto' => $tarData['monto'],
                            ]);
                        }
                    }
                }
            }
        }
    }
    return redirect()->route('proyecto.index')->with('success','Proyecto Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $proyecto = proyecto::with(['componentesProyecto.actividadesProyecto.tareasProyecto','objetivosEstrategicos','metasEstrategicas'])->findOrFail($id);
        $entidad = entidad::all();
        $objetivoEstrategico = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();
        return view('proyecto.edit',compact('proyecto','entidad','objetivoEstrategico','metasEstrategicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         BitacoraHelper::registrar('Proyecto', 'Actualizó el proyecto con ID ' . $id);
        $request->validate([
            'cup' => 'unique:proyecto,cup',
            'tipo_dictamen' => 'required|in:prioridad,aprobacion,actualizacion_prioridad,actualizacion_aprobacion',    
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'accion' => 'required|string',
            'objeto' => 'required|string',
            'plazo_ejecucion' => 'required|string|max:50',
            'monto_total' => 'required|numeric|min:0',
            'diagnostico' => 'nullable|string',
            'problema' => 'nullable|string',
            'longitud' => 'nullable|numeric',
            'latitud' => 'nullable|numeric',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
            'componentesProyecto' => 'nullable|array',
            'componentesProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.descripcion' => 'nullable|string',
            'componentesProyecto.*.monto' => 'required|numeric',
            'componentesProyecto.*.actividadesProyecto' => 'nullable|array',
            'componentesProyecto.*.actividadesProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.actividadesProyecto.*.monto' => 'required|numeric',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto' => 'nullable|array',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto.*.nombre' => 'required|string',
            'componentesProyecto.*.actividadesProyecto.*.tareasProyecto.*.monto' => 'required|numeric',
        ]);
       $proyecto = proyecto::findOrfail($id);
       $proyecto->update([
         'idEntidad' => $request->idEntidad,
         'tipo_dictamen' => $request->tipo_dictamen,
         'nombre' => ucfirst($request->accion) . ' de ' . $request->objeto,
                  'plazo_ejecucion' => $request->plazo_ejecucion,
         'monto_total' => $request->monto_total,
         'diagnostico' => $request->diagnostico,
         'problema' => $request->problema,
         'longitud' => $request->longitud,
         'latitud' => $request->latitud,
         'estado_revision' => 'pendiente',
         'estado_autoridad' => 'pendiente',
       ]);
       // Actualiza la relación con los objetivos estratégicos
       if ($request->has('idObjetivoEstrategico')) {
           $proyecto->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
       }
         // Actualiza la relación con las metas estratégicas
       if ($request->has('idMetaEstrategica')) {
           $proyecto->metasEstrategicas()->sync($request->idMetaEstrategica);
       }
       $proyecto->componentesProyecto()->delete();
       if ($request->has('componentesProyecto')) {
            foreach ($request->input('componentesProyecto') as $compData) {
                $componenteProyecto = $proyecto->componentesProyecto()->create([
                    'nombre' => $compData['nombre'],
                    'descripcion' => $compData['descripcion'] ?? null,
                    'monto' => $compData['monto'],
                ]);

                if (isset($compData['actividadesProyecto'])) {
                    foreach ($compData['actividadesProyecto'] as $actData) {
                        $actividadProyecto = $componenteProyecto->actividadesProyecto()->create([
                            'nombre' => $actData['nombre'],
                            'monto' => $actData['monto'],
                        ]);

                        if (isset($actData['tareasProyecto'])) {
                            foreach ($actData['tareasProyecto'] as $tarData) {
                                $actividadProyecto->tareasProyecto()->create([
                                    'nombre' => $tarData['nombre'],
                                    'monto' => $tarData['monto'],
                                ]);
                            }
                        }
                    }
                }
            }
        }
    return redirect()->route('proyecto.index')->with('success','Proyecto Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        BitacoraHelper::registrar('Proyecto', 'Eliminó el proyecto con ID ' . $id);
        $proyecto = proyecto::findOrfail($id);
        $proyecto->delete();
return redirect()->route('proyecto.index')->with('success','Proyecto Eliminado satisfactoriamente');
    }
}
