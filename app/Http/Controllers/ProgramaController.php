<?php

namespace App\Http\Controllers;

use App\Models\programa;
use App\Models\entidad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoEnum; 

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $programa =programa::all(); 
        return view('programa.index',compact('programa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entidad = entidad::all();
       return view('programa.create', compact('entidad'));
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
       programa::create($request->all());
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
        return view('programa.edit',compact('programa','entidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idEntidad'=>'required|exists:entidad,idEntidad',
            'nombre'=>'required|string',
            'estado'=>['required',Rule::in(EstadoEnum::values())],
        ]);
       $programa = programa::findOrfail($id);
       $programa->update($request->all());
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
