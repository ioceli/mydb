<?php
namespace App\Http\Controllers;
use App\Models\metaPlanNacional;
use App\Helpers\BitacoraHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetaPlanNacionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $metaPlanNacional =metaPlanNacional::all(); 
        return view('metaPlanNacional.index',compact('metaPlanNacional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('metaPlanNacional.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BitacoraHelper::registrar('MetaPlanNacional', 'Creó una nueva meta del plan nacional');
          $request->validate([
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'porcentajeAlineacion'=>'required|numeric',
        ]);
       metaPlanNacional::create($request->all());
    return redirect()->route('metaPlanNacional.index')->with('success','Meta del Plan Nacional Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(metaPlanNacional $metaPlanNacional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
         $metaPlanNacional = metaPlanNacional::findOrfail($id);
        return view('metaPlanNacional.edit',compact('metaPlanNacional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        BitacoraHelper::registrar('MetaPlanNacional', 'Actualizó una meta del plan nacional');
        $request->validate([
            'nombre'=>'required|string', $id . 'idMetaPlanNacional',
            'descripcion'=>'required|string',
            'porcentajeAlineacion'=>'required|numeric',
            
        ]);
       $metaPlanNacional = metaPlanNacional::findOrfail($id);
       $metaPlanNacional->update($request->all());
    return redirect()->route('metaPlanNacional.index')->with('success','Meta del Plan Nacional Actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BitacoraHelper::registrar('MetaPlanNacional', 'Eliminó una meta del plan nacional');
        $metaPlanNacional = metaPlanNacional::findOrfail($id);
        $metaPlanNacional->delete();
return redirect()->route('metaPlanNacional.index')->with('success','Meta del Plan Nacional Eliminada satisfactoriamente');
    }
}
