<?php
namespace App\Http\Controllers;
use App\Models\objetivoDesarrolloSostenible;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObjetivoDesarrolloSostenibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $objetivoDesarrolloSostenible =objetivoDesarrolloSostenible::all(); 
        return view('objetivoDesarrolloSostenible.index',compact('objetivoDesarrolloSostenible'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('objetivoDesarrolloSostenible.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'numero'=>'required|integer',
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            ]);
       objetivoDesarrolloSostenible::create($request->all());
    return redirect()->route('objetivoDesarrolloSostenible.index')->with('success','Objetivo Desarrollo Sostenible Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(objetivoDesarrolloSostenible $objetivoDesarrolloSostenible)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::findOrfail($id);
        return view('objetivoDesarrolloSostenible.edit',compact('objetivoDesarrolloSostenible'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
                $request->validate([
            'numero'=>'required|integer', $id . 'idObjetivoEstrategico',        
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
        ]);
       $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::findOrfail($id);
       $objetivoDesarrolloSostenible->update($request->all());
    return redirect()->route('objetivoDesarrolloSostenible.index')->with('success','Objetivo Desarrollo Sostenible Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::findOrfail($id);
        $objetivoDesarrolloSostenible->delete();
return redirect()->route('objetivoDesarrolloSostenible.index')->with('success','Objetivo Estrategico Eliminado satisfactoriamente');
    }
}
