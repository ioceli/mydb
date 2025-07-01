<?php
namespace App\Http\Controllers;
use App\Models\indicador;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $indicador =indicador::all(); 
        return view('indicador.index',compact('indicador'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('indicador.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'fechaMedicion'=>'required|date',
            'formula'=>'required|string',
            'tipo'=>'required|string',
            'unidadMedida'=>'required|string',
            'valorActual'=>'required|numeric',
            'valorBase'=>'required|numeric',        
            'valorMeta'=>'required|numeric',        
        ]);
       indicador::create($request->all());
    return redirect()->route('indicador.index')->with('success','Indicador Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(indicador $indicador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $indicador = indicador::findOrfail($id);
        return view('indicador.edit',compact('indicador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|string', $id . 'idMetaEstrategica',
            'descripcion'=>'required|string',
            'fechaMedicion'=>'required|date',
            'formula'=>'required|string',
            'tipo'=>'required|string',
            'unidadMedida'=>'required|string',
            'valorActual'=>'required|numeric',
            'valorBase'=>'required|numeric',        
            'valorBase'=>'required|numeric',            
        ]);
       $indicador = indicador::findOrfail($id);
       $indicador->update($request->all());
    return redirect()->route('indicador.index')->with('success','Indicador Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $indicador = indicador::findOrfail($id);
        $indicador->delete();
return redirect()->route('indicador.index')->with('success','Indicador Eliminado satisfactoriamente');
    }
}
