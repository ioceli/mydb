<?php

namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
use App\Models\entidad;
use App\Models\proyecto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoEnum; 

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $proyecto =proyecto::with('entidad','objetivosEstrategicos')->get(); 
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
       return view('proyecto.create', compact('entidad', 'objetivoEstrategico'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
          $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:proyecto,nombre',
            'estado'=>['required', Rule::in(EstadoEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
      ]);
       $proyecto = proyecto::create([
        'idEntidad' => $request->idEntidad,
        'nombre' => $request->nombre,
        'estado' => $request->estado,
    ]);
        // Asocia objetivos estratégicos al proyecto
    if ($request->has('idObjetivoEstrategico')) {
        $proyecto->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
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
        return view('proyecto.edit',compact('proyecto','entidad','objetivoEstrategico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:proyecto,nombre,' . $id . ',idProyecto',
            'estado'=>['required',Rule::in(EstadoEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
        ]);
       $proyecto = proyecto::findOrfail($id);
       $proyecto->update([
         'idEntidad' => $request->idEntidad,
         'nombre' => $request->nombre,
         'estado' => $request->estado,
       ]);
       // Actualiza la relación con los objetivos estratégicos
       if ($request->has('idObjetivoEstrategico')) {
           $proyecto->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
       }
    return redirect()->route('proyecto.index')->with('success','Proyecto Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $proyecto = proyecto::findOrfail($id);
        $proyecto->delete();
return redirect()->route('proyecto.index')->with('success','Proyecto Eliminado satisfactoriamente');
    }
}
