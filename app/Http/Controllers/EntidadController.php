<?php

namespace App\Http\Controllers;

use App\Models\entidad;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Validation\Rules\Unique;
use Ramsey\Uuid\Type\Integer;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entidad =entidad::all(); 
        return view('entidad.index',compact('entidad'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('entidad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo'=>'required|integer|unique:entidad,codigo',
            'subSector'=>'required|string',
            'nivelGobierno'=>'required|string',
            'estado'=>'required|string',
            'fechaCreacion'=>'required|date',
            'fechaActualizacion'=>'nullable|date',
       ]);
       entidad::create($request->all());
    return redirect()->route('entidad.index')->with('success','Entidad Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(entidad $entidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $entidad = entidad::findOrfail($id);
        return view('entidad.edit',compact('entidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo'=>'required|integer|unique:entidad,codigo', $id .'idEntidad',
            'subSector'=>'required|string',
            'nivelGobierno'=>'required|string',
            'estado'=>'required|string',
            'fechaCreacion'=>'required|date',
            'fechaActualizacion'=>'nullable|date',
       ]);
       $entidad = entidad::findOrfail($id);
       entidad::update($request->all());
    return redirect()->route('entidad.index')->with('success','Entidad Actualizada satisfactoriamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $entidad = entidad::findOrfail($id);
        $entidad->delete();
return redirect()->route('entidad.index')->with('success','Entidad Eliminada satisfactoriamente');

    }
}
