<?php
namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
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
          $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:programa,nombre',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',    
            'idMetaEstrategica' => 'nullable|array',
        ]);
       $programa= programa::create([
        'idEntidad' => $request->idEntidad,
        'nombre' => $request->nombre,
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
        $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string|unique:programa,nombre,'.$id.',idPrograma',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
        ]);
       $programa = programa::findOrfail($id);
       $programa->update([
         'idEntidad' => $request->idEntidad,
         'nombre' => $request->nombre,
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
        $programa = programa::findOrfail($id);
        $programa->delete();
return redirect()->route('programa.index')->with('success','Programa Eliminado satisfactoriamente');
    }
}
