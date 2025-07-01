<?php
namespace App\Http\Controllers;
use App\Models\metaEstrategica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetaEstrategicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $metaEstrategica =metaEstrategica::all(); 
        return view('metaEstrategica.index',compact('metaEstrategica'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('metaEstrategica.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date',
            'formulaIndicador'=>'required|string',
            'metaEsperada'=>'required|numeric',
            'progresoActual'=>'required|numeric',
            'tipoIndicador'=>'required|integer',        
            'unidadMedida'=>'required|string',        
        ]);
       metaEstrategica::create($request->all());
    return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(metaEstrategica $metaEstrategica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
         $metaEstrategica = metaEstrategica::findOrfail($id);
        return view('metaEstrategica.edit',compact('metaEstrategica'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|string', $id . 'idMetaEstrategica',
            'descripcion'=>'required|string',
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date',
            'formulaIndicador'=>'required|string',
            'metaEsperada'=>'required|numeric',
            'progresoActual'=>'required|numeric',
            'tipoIndicador'=>'required|integer',        
            'unidadMedida'=>'required|string',            
        ]);
       $metaEstrategica = metaEstrategica::findOrfail($id);
       $metaEstrategica->update($request->all());
    return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $metaEstrategica = metaEstrategica::findOrfail($id);
        $metaEstrategica->delete();
return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Eliminada satisfactoriamente');
    }
}
