<?php

namespace App\Http\Controllers;

use App\Models\auditoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $auditoria =auditoria::all(); 
        return view('auditoria.index',compact('auditoria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('auditoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'nombre'=>'required|string',
      ]);
       auditoria::create($request->all());
    return redirect()->route('auditoria.index')->with('success','Auditoria Creada satisfactoriamente'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(auditoria $auditoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $auditoria = auditoria::findOrfail($id);
        return view('auditoria.edit',compact('auditoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'nombre'=>'required|string', $id . 'idPLan',
        ]);
       $auditoria = auditoria::findOrfail($id);
       $auditoria->update($request->all());
    return redirect()->route('auditoria.index')->with('success','Auditoria Actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $auditoria = auditoria::findOrfail($id);
        $auditoria->delete();
return redirect()->route('auditoria.index')->with('success','Auditoria Eliminada satisfactoriamente');
    }
}
