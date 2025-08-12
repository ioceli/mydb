<?php
namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
use App\Helpers\BitacoraHelper;
use App\Models\metaEstrategica;
use App\Models\programa;
use App\Models\entidad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoRevisionEnum; 
use App\Enums\EstadoAutoridadEnum;
class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $programa = programa::with('entidad','objetivosEstrategicos','metasEstrategicas')->get(); 
       if ($programa->isEmpty()) {
        return view('programa.index', ['programa' => $programa, 'message' => 'No hay programas registrados.']);
       }
         return view('programa.index',compact('programa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entidad = entidad::all();
        $objetivoEstrategico = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();
        return view('programa.create', compact('entidad','objetivoEstrategico','metasEstrategicas'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        BitacoraHelper::registrar('Programa', 'Creó un nuevo programa');
          $request->validate([
            'cup' => 'unique:programa,cup',
            'tipo_dictamen' => 'required|in:prioridad,aprobacion,actualizacion_prioridad,actualizacion_aprobacion',
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'accion' => 'required|string',
            'objeto' => 'required|string',
            'nombre' => 'required|string|max:255',
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
            'componentes' => 'nullable|array',
            'componentes.*.nombre' => 'required|string',
            'componentes.*.descripcion' => 'nullable|string',
            'componentes.*.monto' => 'required|numeric',
            'componentes.*.actividades' => 'nullable|array',
            'componentes.*.actividades.*.nombre' => 'required|string',
            'componentes.*.actividades.*.monto' => 'required|numeric',
            'componentes.*.actividades.*.tareas' => 'nullable|array',
            'componentes.*.actividades.*.tareas.*.nombre' => 'required|string',
            'componentes.*.actividades.*.tareas.*.monto' => 'required|numeric',
        ]);
       $programa= programa::create([
         'cup' => programa::generarCUP(),
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
        // Asocia objetivos estratégicos al programa
    if ($request->has('idObjetivoEstrategico')) {
        $programa->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
    }
        // Asocia metas estratégicas al programa
    if ($request->has('idMetaEstrategica')) {
        $programa->metasEstrategicas()->sync($request->idMetaEstrategica);
    }
    if ($request->has('componentes')) {
    foreach ($request->input('componentes') as $compData) {
        $componente = $programa->componentes()->create([
            'nombre' => $compData['nombre'],
            'descripcion' => $compData['descripcion'] ?? null,
            'monto' => $compData['monto'],
        ]);

        if (isset($compData['actividades'])) {
            foreach ($compData['actividades'] as $actData) {
                $actividad = $componente->actividades()->create([
                    'nombre' => $actData['nombre'],
                    'monto' => $actData['monto'],
                ]);

                if (isset($actData['tareas'])) {
                    foreach ($actData['tareas'] as $tarData) {
                        $actividad->tareas()->create([
                            'nombre' => $tarData['nombre'],
                            'monto' => $tarData['monto'],
                        ]);
                    }
                }
            }
        }
    }
}
    return redirect()->route('programa.index')->with('success','Programa Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(programa $programa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $programas = programa::with(['componentes.actividades.tareas', 'objetivosEstrategicos', 'metasEstrategicas'])->findOrFail($id);
        $entidades = entidad::all();
        $objetivosEstrategicos = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();

        return view('programa.edit',compact('programas','entidades', 'objetivosEstrategicos', 'metasEstrategicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $programas = Programa::findOrFail($id);
        BitacoraHelper::registrar('Programa', 'Actualizó el programa con ID ' . $programas->idPrograma);
        $request->validate([
            'cup' => 'unique:programa,cup',
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
            'componentes' => 'nullable|array',
            'componentes.*.nombre' => 'required_with:componentes|string',
            'componentes.*.descripcion' => 'nullable|string',
            'componentes.*.monto' => 'required_with:componentes|numeric',
            'componentes.*.actividades' => 'nullable|array',
            'componentes.*.actividades.*.nombre' => 'required_with:componentes.*.actividades|string',
            'componentes.*.actividades.*.monto' => 'required_with:componentes.*.actividades|numeric',
            'componentes.*.actividades.*.tareas' => 'nullable|array',
            'componentes.*.actividades.*.tareas.*.nombre' => 'required_with:componentes.*.actividades.*.tareas|string',
            'componentes.*.actividades.*.tareas.*.monto' => 'required_with:componentes.*.actividades.*.tareas|numeric',
        ]);
         // Actualiza los campos del programa

       $programas->update([
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
           $programas->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
       }
       // Actualiza la relación con las metas estratégicas
       if ($request->has('idMetaEstrategica')) {
           $programas->metasEstrategicas()->sync($request->idMetaEstrategica);
       }
        $programas->componentes()->delete();

        if ($request->has('componentes')) {
            foreach ($request->input('componentes') as $compData) {
                $componente = $programas->componentes()->create([
                    'nombre' => $compData['nombre'],
                    'descripcion' => $compData['descripcion'] ?? null,
                    'monto' => $compData['monto'],
                ]);

                if (isset($compData['actividades'])) {
                    foreach ($compData['actividades'] as $actData) {
                        $actividad = $componente->actividades()->create([
                            'nombre' => $actData['nombre'],
                            'monto' => $actData['monto'],
                        ]);

                        if (isset($actData['tareas'])) {
                            foreach ($actData['tareas'] as $tarData) {
                                $actividad->tareas()->create([
                                    'nombre' => $tarData['nombre'],
                                    'monto' => $tarData['monto'],
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('programa.index')->with('success', 'Programa actualizado satisfactoriamente');
    
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        BitacoraHelper::registrar('Programa', 'Eliminó el programa con ID ' . $id);
        $programa = programa::findOrfail($id);
        $programa->delete();
return redirect()->route('programa.index')->with('success','Programa Eliminado satisfactoriamente');
    }
}

