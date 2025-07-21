<?php
namespace App\Http\Controllers;
use App\Models\objetivoDesarrolloSostenible;
use App\Helpers\BitacoraHelper;
use App\Models\objetivoEstrategico;
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
        $objetivoEstrategico = objetivoEstrategico::all();
        
       return view('objetivoDesarrolloSostenible.create', compact('objetivoEstrategico'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BitacoraHelper::registrar('ObjetivoDesarrolloSostenible', 'Creó un nuevo objetivo de desarrollo sostenible');
          $request->validate([
            'idObjetivoEstrategico' => 'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'numero'=>'required|integer|unique:objetivo_desarrollo_sostenible,numero',
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            ]);
       objetivoDesarrolloSostenible::create([
            'idObjetivoEstrategico' => $request->idObjetivoEstrategico,
            'numero' => $request->numero,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
       
       
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
        $objetivoEstrategico = objetivoEstrategico::all();
        return view('objetivoDesarrolloSostenible.edit',compact('objetivoDesarrolloSostenible', 'objetivoEstrategico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        BitacoraHelper::registrar('ObjetivoDesarrolloSostenible', 'Actualizó un objetivo de desarrollo sostenible');
                $request->validate([
            'idObjetivoEstrategico'=>'required|exists:objetivo_estrategico,idObjetivoEstrategico',
            'numero'=>'required|integer', $id . 'idObjetivoEstrategico',        
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
        ]);
       $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::findOrfail($id);
       $objetivoDesarrolloSostenible->update([
        'idObjetivoEstrategico' => $request->idObjetivoEstrategico,
        'numero' => $request->numero,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
         ]);
    return redirect()->route('objetivoDesarrolloSostenible.index')->with('success','Objetivo Desarrollo Sostenible Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BitacoraHelper::registrar('ObjetivoDesarrolloSostenible', 'Eliminó un objetivo de desarrollo sostenible');
         $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::findOrfail($id);
        $objetivoDesarrolloSostenible->delete();
return redirect()->route('objetivoDesarrolloSostenible.index')->with('success','Objetivo Estrategico Eliminado satisfactoriamente');
    }
}
