<?php

namespace App\Http\Controllers;
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
         $proyecto =proyecto::all(); 
        return view('proyecto.index',compact('proyecto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entidad = entidad::all();
       return view('proyecto.create', compact('entidad'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
          $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string',
            'estado'=>['required', Rule::in(EstadoEnum::values())],
      ]);
       proyecto::create($request->all());
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
        return view('proyecto.edit',compact('proyecto','entidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string', $id . 'idProyecto',
            'estado'=>['required',Rule::in(EstadoEnum::values())],
        ]);
       $proyecto = proyecto::findOrfail($id);
       $proyecto->update($request->all());
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
