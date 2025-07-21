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
class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $proyecto =proyecto::with('entidad','objetivosEstrategicos','metasEstrategicas')->get(); 
        if ($proyecto->isEmpty()) {
            return view('proyecto.index', ['proyecto' => $proyecto, 'mensaje' => 'No hay proyectos registrados.']);
        }
         return view('proyecto.index',compact('proyecto'));
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
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:proyecto,nombre',
           'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
      ]);
       $proyecto = proyecto::create([
        'idEntidad' => $request->idEntidad,
        'nombre' => $request->nombre,
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
         $proyecto = proyecto::findOrfail($id);
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
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:proyecto,nombre,' . $id . ',idProyecto',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
        ]);
       $proyecto = proyecto::findOrfail($id);
       $proyecto->update([
         'idEntidad' => $request->idEntidad,
         'nombre' => $request->nombre,
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
