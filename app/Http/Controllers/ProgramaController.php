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
            'tipo_dictamen' => 'required|in:prioridad,aprobacion,actualizacion_prioridad,actualizacion_aprobacion',
            'idEntidad'=>'required|exists:entidad,idEntidad',
            
             'accion' => 'required|string',
            'objeto' => 'required|string',
            'plazo_ejecucion' => 'required|string|max:50',
            'monto_total' => 'required|numeric|min:0',
            'diagnostico' => 'nullable|string',
            'marco_logico' => 'nullable|string',
            'analisis_integral' => 'nullable|string',
            'financiamiento' => 'nullable|string',
            'estrategia_ejecucion' => 'nullable|string',
            'seguimiento_evaluacion' => 'nullable|string',
            'anexos' => 'nullable|string',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',    
            'idMetaEstrategica' => 'nullable|array',
        ]);
       $programa= programa::create([
         'cup' => programa::generarCUP(),
        'idEntidad' => $request->idEntidad,
        'tipo_dictamen' => $request->tipo_dictamen,
        'nombre' => ucfirst($request->accion) . ' de ' . $request->objeto,
        'plazo_ejecucion' => $request->plazo_ejecucion,
        'monto_total' => $request->monto_total,
        'diagnostico' => $request->diagnostico,
        'marco_logico' => $request->marco_logico,
        'analisis_integral' => $request->analisis_integral,
        'financiamiento' => $request->financiamiento,
        'estrategia_ejecucion' => $request->estrategia_ejecucion,
        'seguimiento_evaluacion' => $request->seguimiento_evaluacion,
        'anexos' => $request->anexos,
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
    public function edit($id)
    {
         $programa = programa::findOrfail($id);
         $entidad = entidad::all();
         $objetivoEstrategico = objetivoEstrategico::all();
         $metasEstrategicas = metaEstrategica::all();

        return view('programa.edit',compact('programa','entidad', 'objetivoEstrategico', 'metasEstrategicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         BitacoraHelper::registrar('Programa', 'Actualizó el programa con ID ' . $id);
        $request->validate([
            
            'tipo_dictamen' => 'required|in:prioridad,aprobacion,actualizacion_prioridad,actualizacion_aprobacion',
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'accion' => 'required|string',
            'objeto' => 'required|string',
            'plazo_ejecucion' => 'required|string|max:50',
            'monto_total' => 'required|numeric|min:0',
            'diagnostico' => 'nullable|string',
            'marco_logico' => 'nullable|string',
            'analisis_integral' => 'nullable|string',
            'financiamiento' => 'nullable|string',
            'estrategia_ejecucion' => 'nullable|string',
            'seguimiento_evaluacion' => 'nullable|string',
            'anexos' => 'nullable|string',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',    
            'idMetaEstrategica' => 'nullable|array',
        ]);
       $programa = programa::findOrfail($id);
       $programa->update([
         'cup' => programa::generarCUP(),
        'idEntidad' => $request->idEntidad,
        'tipo_dictamen' => $request->tipo_dictamen,
        'nombre' => ucfirst($request->accion) . ' de ' . $request->objeto,
        'plazo_ejecucion' => $request->plazo_ejecucion,
        'monto_total' => $request->monto_total,
        'diagnostico' => $request->diagnostico,
        'marco_logico' => $request->marco_logico,
        'analisis_integral' => $request->analisis_integral,
        'financiamiento' => $request->financiamiento,
        'estrategia_ejecucion' => $request->estrategia_ejecucion,
        'seguimiento_evaluacion' => $request->seguimiento_evaluacion,
        'anexos' => $request->anexos,
        'estado_revision' => 'pendiente',
        'estado_autoridad' => 'pendiente',
       ]);
       // Actualiza la relación con los objetivos estratégicos
       if ($request->has('idObjetivoEstrategico')) {
           $programa->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
       }
       // Actualiza la relación con las metas estratégicas
       if ($request->has('idMetaEstrategica')) {
           $programa->metasEstrategicas()->sync($request->idMetaEstrategica);
       }
    return redirect()->route('programa.index')->with('success','Programa Actualizado satisfactoriamente');
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
